<?php


namespace app\core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MAX = 'max';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';

    public array $errors = [];

    public function loadData($data){
        foreach ($data as $key => $value){
            if(property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    abstract public function rules(): array;

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules)
        {
            $value = $this->{$attribute};

            foreach ($rules as $rule)
            {
                $ruleName = $rule;
                if(!is_string($ruleName))
                    $ruleName = $rule[0];

                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
            }
        }

        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule)
    {
        $message = $this->errorMessages()[$rule];
        $this->errors[$attribute][] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Поле не должно быть пустым',
            self::RULE_MATCH => 'Это поле должно совпадать с полем {match}',
            self::RULE_MIN => 'Минимальный размер этого поля {min}',
            self::RULE_MAX => 'Максимальный размер этого поля {max}',
            self::RULE_EMAIL => 'Email неправильный'
        ];
    }
}