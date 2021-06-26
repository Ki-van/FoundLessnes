<?php


namespace app\models;


use app\core\Model;

class ParticipationForm extends Model
{
    public string $heading = '';
    public string $description = '';
    public string $email = '';
    public $file = null;

    public function rules(): array
    {
        return [
            'heading' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 64]],
            'description' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 600]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'file' => [self::RULE_REQUIRED, [self::RULE_FILE_ACCEPT, 'accept' => 'text/plain|application/msword|application/pdf' ]]
        ];
    }

    public function labels(): array
    {
        return [
            'heading' => 'Тема статьи',
            'description' => 'Краткое описание',
            'email' => 'Почта',
            'file' => 'Статья'
        ];
    }

}