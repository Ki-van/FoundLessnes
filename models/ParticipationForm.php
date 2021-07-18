<?php


namespace app\models;


use app\core\file\UploadedFile;
use app\core\file\UploadedText;
use app\core\Model;

class ParticipationForm extends Model
{
    public string $heading = '';
    public string $description = '';
    public string $email = '';
    public array $files = [];

    public function rules(): array
    {
        return [
            'heading' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 64]],
            'description' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 600]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'files' => [
                self::RULE_REQUIRED,
                self::RULE_MODEL
            ]
        ];
    }

    public function labels(): array
    {
        return [
            'heading' => 'Тема статьи',
            'description' => 'Краткое описание',
            'email' => 'Почта',
            'files' => 'Документы'
        ];
    }


}