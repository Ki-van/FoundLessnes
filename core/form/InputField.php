<?php


namespace app\core\form;


use app\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_FILE = 'file';


    public string $type = self::TYPE_TEXT;
    public string $accept = '';

    public function __construct(Model $model, string $attribute)
    {
        parent::__construct($model, $attribute);
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField(string $accept)
    {
        $this->type = self::TYPE_FILE;
        $this->accept = $accept;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf(' <input type="%s" name="%s" value="%s" class="%s" accept="%s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->accept
        );
    }
}