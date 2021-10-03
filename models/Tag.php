<?php

namespace app\models;

use app\core\DbModel;

class Tag extends DbModel
{
    public string $tag_name;

    static public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['tag_name'];
    }

    static public function tableName(): string
    {
        return 'tag';
    }

    public function rules(): array
    {
        return [];
    }
}