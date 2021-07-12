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
        $user = User::get_one_user($this->email, $this->password);

        if (!$user) {
            $this->addError('email', '');
            $this->addError('password', 'Пароль или почта неправильные');
            return false;
        }

        return Application::$app->login($user);
    }

}