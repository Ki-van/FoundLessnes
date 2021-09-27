<?php


namespace app\core\form;


use app\core\Model;

class SelectField extends BaseField
{
    public array $options;
    public string $selected = " ";
    public bool $multiple = false;

    public function renderInput(): string
    {
        $options = "";
        foreach ($this->options as $value => $option) {
            $options .= sprintf('<option value="%s" %s>%s</option> \n',
                $value,
                $option == $this->selected? 'selected':'',
                $option);
        }
        return sprintf('<select name="%s" %s>%s</select>',
            $this->attribute,
            $this->multiple?'multiple':'',
            $options
        );
    }

    /**
     * @param array $options key - value of the option, value - innerHTML
     * @return $this
     */
    public function options(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    public function selected($selected): static
    {
        $this->selected = $selected;
        return $this;
    }

    public function multiple(): static
    {
        $this->multiple = true;
        return $this;
    }

}