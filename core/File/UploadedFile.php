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
    public int $error;

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
        foreach ($this->rules() as $ruleName => $rule) {

            if ($this->error != UPLOAD_ERR_OK) {
                $this->addErrorForRule('name', self::RULE_FILE, ['file_error' => $this->errorCodeToMessage($this->error)]);
                break;
            }

            if ($ruleName === self::RULE_FILE_ACCEPT && !in_array($this->type, explode(',', $rule))) {
                $this->addErrorForRule('type', self::RULE_FILE_ACCEPT, ['name' => $this->name]);
            }
            if ($ruleName === self::RULE_FILE_SIZE && $this->size > $rule) {
                $this->addErrorForRule('size', self::RULE_FILE_SIZE, ['name' => $this->name, 'file_size' => $this->size / 1000000]);
            }
        }

        return empty($this->errors);
    }

    function rules(): array
    {
        return [];
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

    protected function errorMessages(): array
    {
        return [
            self::RULE_FILE => '{file_error}',
            self::RULE_FILE_ACCEPT => '* Файл {name} недопустимого типа',
            self::RULE_FILE_SIZE => '* Файл {name} больше {file_size} Мб'
        ];
    }
}
