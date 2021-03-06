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
    public const RULE_MODEL = 'model';

    public array $errors = [];

    abstract public function rules(): array;

    public function loadData($data)
    {
        if (Application::$app->request->isPost()) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key))
                    if(!is_string($value) && is_string($this->{$key}))
                        $this->{$key} = json_encode($value);
                    else
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
                for ($i = 0; $i < sizeof($_FILES['name']); $i++) {
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
                    break;
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

                if ($ruleName === self::RULE_MODEL) {
                    if (is_array($value)) {
                        /**
                         * @var $model Model
                         */
                        foreach ($value as $model) {
                            $model->validate();
                            $this->addErrorsForModel($attribute, $model->errors);
                        }
                    }
                }

            }
        }

        return empty($this->errors);
    }

    protected function addErrorForRule(string $attribute, string $rule, array $params = [])
    {

        $message = $this->errorMessages()[$rule];
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    protected function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => '* ???????? ???? ???????????? ???????? ????????????',
            self::RULE_MATCH => '* ?????? ???????? ???????????? ?????????????????? ?? ?????????? {match}',
            self::RULE_MIN => '* ?????????????????????? ???????????? ?????????? ???????? {min}',
            self::RULE_MAX => '* ???????????????????????? ???????????? ?????????? ???????? {max}',
            self::RULE_EMAIL => '* Email ????????????????????????',
            self::RULE_UNIQUE => '* ???????????? ???? ?????????????????? ?? ???????? {field} ?????? ????????',
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

    public function addErrorsForModel(string $attribute, array $errors)
    {
        $this->errors[$attribute] = $errors;
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
        return  $this->errors[$attribute][0] ?? false;
    }

    /**
     * @param array $attributes
     * @return string that contains java script with defined in there variables
     */
    public function exportToJSScript(array $attributes):string
    {
        $script = "<script>";
        foreach ($attributes as $attribute) {
            if(property_exists($this, $attribute)) {
                $script .= "let $attribute = ";

                if(is_string($this->{$attribute}))
                    $script .= "'".$this->{$attribute}."'";
                elseif(is_array($this->{$attribute}))
                    $script .= "'".json_encode($this->{$attribute})."'";
                else
                    $script .= $this->{$attribute};

                $script .= '; \n';
            }
        }

        $script .= '</script>';
        return $script;
    }
}