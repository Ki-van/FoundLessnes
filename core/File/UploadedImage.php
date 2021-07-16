<?php


namespace app\core\file;


class UploadedImage extends UploadedFile
{

    public function rules(): array
    {
        return
            [
                self::RULE_FILE_ACCEPT =>
                    'image/jpeg,image/pjpeg,image/png',
                self::RULE_FILE_SIZE => 1000000
            ];
    }
}