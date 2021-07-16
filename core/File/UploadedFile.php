<?php


namespace app\core\file;


use app\core\Model;

class UploadedFile extends Model
{
    public const RULE_FILE = 'file';
    public const RULE_FILE_ACCEPT = 'file_accept';
    public const RULE_FILE_SIZE = 'file_size'; //bytes

    public string $name;
    public string $tmp_name;
    public string $type;
    public int $size;
    private int $error;

    /**
     * UploadedFile constructor.
     * @param array $fileFields name, type, size etc..
     */
    public function __construct(array $fileFields)
    {
        foreach ($fileFields as $key => $value) {
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }


    public function move(string $directory, string $name = null)
    {
        if (!$name)
            $name = str_replace(' ', '_', filter_var(transliterator_transliterate('Russian-Latin/BGN', $this->name), FILTER_SANITIZE_SPECIAL_CHARS));

        $moved = move_uploaded_file($this->tmp_name, "$directory\\" . $name);

        if (!$moved) {
            throw new \Exception('Fail to move file');
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

                /**
                 * @var $value UploadedFile
                 */
                if ($value->error != UPLOAD_ERR_OK) {
                    $this->addErrorForRule($attribute, self::RULE_FILE, ['file_error' => $value->errorCodeToMessage($this->error)]);
                    continue;
                }

                if ($ruleName === self::RULE_FILE_ACCEPT && !in_array($value->type, explode(',', $rule[self::RULE_FILE_ACCEPT]))) {
                    $this->addErrorForRule($attribute, self::RULE_FILE_ACCEPT, ['name' => $value->name]);
                }
                if ($value->size > $rule[self::RULE_FILE_SIZE]) {
                    $this->addErrorForRule($attribute, self::RULE_FILE_SIZE, ['name' => $value->name, 'file_size' => $value->size / 1000000]);
                }
            }
        }
    }

    function rules(): array
    {
        return [];
    }

    protected function errorMessages(): array
    {
        return [
            self::RULE_FILE => '{file_error}',
            self::RULE_FILE_ACCEPT => '* Файл {name} недопустимого типа',
            self::RULE_FILE_SIZE => '* Файл {name} больше {file_size} Мб'
        ];
    }

    protected function errorCodeToMessage($code): string
    {
        switch ($code) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = "Файл слишком большой";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "Файл скачан был лишь частично";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "Файл не загружен";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Ошибка загрузки файла";
                break;
        }
        return $message;
    }
}
