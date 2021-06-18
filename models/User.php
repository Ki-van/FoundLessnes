<?php


namespace app\models;


use app\core\DbModel;
use app\core\Model;

class User extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $name = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes(): array
    {
        return ['name', 'email', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'name' => 'Имя',
            'email' => 'Почта',
            'password' => 'Пароль',
            'passwordConfirm' => 'Подтвердите пароль'
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }


}