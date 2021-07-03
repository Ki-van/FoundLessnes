<?php


namespace app\core;


use app\core\file\UploadedFile;
use Dotenv\Store\FileStore;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MAX = 'max';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_FILE = 'file';
    public const RULE_FILE_ACCEPT = 'file_accept';
    public const RULE_FILE_SIZE = 'file_size'; //bytes


    public array $errors = [];

    public function loadData($data)
    {
        if (Application::$app->request->isPost()) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key))
                    $this->{$key} = $value;

            }
        }
    }

    public function loadFiles()
    {
        foreach ($_FILES as $key => $value) {
            $this->{$key} = [];
            if (is_array($value)) {
                $fileFields = [];
                for ($i = 0; $i < UploadedFile::filesCount($value); $i++) {
                    foreach ($value as $fileField => $files) {
                        $fileFields[$fileField] = $files[$i];
                    }
                    $this->{$key}[] = new UploadedFile($fileFields);
                }
            } else
                $this->{$key}[] = $value;
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName))
                    $ruleName = $rule[0];

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $tableName = $rule['class']::tableName();
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $statement = Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(':attr', $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }

                if ($ruleName === self::RULE_FILE) {
                    foreach ($value as $file) {
                        /**
                         * @var $file UploadedFile
                         */
                        if ($file->error != UPLOAD_ERR_OK) {
                            $this->addErrorForRule($attribute, self::RULE_FILE, ['file_error' => $file->getErrorMessage()]);
                            continue;
                        }

                        if (!in_array($file->type, explode(',', $rule[self::RULE_FILE_ACCEPT]))) {
                            $this->addErrorForRule($attribute, self::RULE_FILE_ACCEPT, ['name' => $file->name]);
                        }
                        if ($file->size > $rule[self::RULE_FILE_SIZE]) {
                            $this->addErrorForRule($attribute, self::RULE_FILE_SIZE, ['name' => $file->name, 'file_size' => $file->size / 1000000]);
                        }
                    }
                }

            }
        }

        return empty($this->errors);
    }

    abstract public function rules(): array;

    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {

        $message = $this->errorMessages()[$rule];
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => '* Поле не должно быть пустым',
            self::RULE_MATCH => '* Это поле должно совпадать с полем {match}',
            self::RULE_MIN => '* Минимальный размер этого поля {min}',
            self::RULE_MAX => '* Максимальный размер этого поля {max}',
            self::RULE_EMAIL => '* Email неправильный',
            self::RULE_UNIQUE => '* Запись со значением в поле {field} уже есть',
            self::RULE_FILE => '{file_error}',
            self::RULE_FILE_ACCEPT => '* Файл {name} недопустимого типа',
            self::RULE_FILE_SIZE => '* Файл {name} больше {file_size} Мб'
        ];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function labels(): array
    {
        return [];
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}