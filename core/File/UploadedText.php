<?php


namespace app\core\file;


class UploadedText extends UploadedFile
{
    public function rules(): array
    {
        return [
            self::RULE_FILE_ACCEPT =>
                'text/plain,application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/rtf',
            self::RULE_FILE_SIZE => 2000000
        ];
    }
}