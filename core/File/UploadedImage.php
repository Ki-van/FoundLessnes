<?php


namespace app\core\file;


class UploadedImage extends UploadedFile
{

    public function rules(): array
    {
        return
            [
                parent::RULE_FILE_ACCEPT =>
                    'image/jpeg,image/pjpeg,image/png',
                parent::RULE_FILE_SIZE => 60000000
            ];
    }
}