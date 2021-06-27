<?php


namespace app\core\form;


class InputFileField extends BaseField
{
    public string $accept = '';
    public bool $multiple = false;

    public function renderInput(): string
    {
        return sprintf(' <input type="file" name="%s" class="%s" %s accept="%s">',
            $this->attribute . '[]',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->multiple ? 'multiple' : '',
            $this->accept
        );
    }

    /**
     * @param string $accept
     */
    public function accept(string $accept): InputFileField
    {
        $this->accept = $accept;
        return $this;
    }

    /**
     * @param bool $multiple
     */
    public function multiple(bool $multiple): InputFileField
    {
        $this->multiple = $multiple;
        return $this;
    }


}