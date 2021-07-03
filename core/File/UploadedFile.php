<?php


namespace app\core\file;


class UploadedFile extends File
{
    public string $name;
    public string $tmp_name;
    public string $type;
    public int $size;
    public int $error;

    public function __construct(array $fileFields)
    {
        foreach ($fileFields as $key => $value) {
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    public static function filesCount(array $files): int
    {
        if ($files['name']) {
            return sizeof($files['name']);
        } else
            return -1;
    }

    public function getErrorMessage(): string
    {
        return $this->codeToMessage($this->error);
    }

    private function codeToMessage($code): string
    {
        switch ($code) {
            case UPLOAD_ERR_OK: break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file too big";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }
}
