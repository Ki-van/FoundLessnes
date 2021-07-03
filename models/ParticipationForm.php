<?php


namespace app\models;


use app\core\file\UploadedFile;
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
                [
                    self::RULE_FILE,
                    self::RULE_FILE_ACCEPT =>
                        'text/plain,application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/rtf',
                    self::RULE_FILE_SIZE => 2000000
                ]
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