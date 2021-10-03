<?php


namespace app\core\form;


use app\core\Model;

class SelectField extends BaseField
{
    private array $options;
    private array|string $selected;
    private bool $multiple = false;

    public function renderInput(): string
    {
        $options = "";
        foreach ($this->options as $value => $option) {
            if (is_array($this->selected)) {
                $isSelected = array_search($value, $this->selected) ? 'selected' : '';
            } else
                $isSelected = $value == $this->selected ? 'selected' : '';

            $options .= sprintf('<option value="%s" %s>%s</option> \n',
                $value,
                $isSelected,
                $option);
        }
        return sprintf('<select name="%s" %s>%s</select>',
            $this->attribute,
            $this->multiple ? 'multiple' : '',
            $options
        );
    }

    public function selected($selected): static
    {
        $this->selected = $selected;
        return $this;
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

    public function multiple(): static
    {
        $this->multiple = true;
        return $this;
    }

}