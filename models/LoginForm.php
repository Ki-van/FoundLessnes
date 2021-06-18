<?php


namespace app\models;


use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', 'Пользователя с такой почтой не существует');
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Пароль неверный');
            return false;
        }

        return Application::$app->login($user);
    }

}