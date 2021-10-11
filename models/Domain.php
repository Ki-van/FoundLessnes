<?php

namespace app\models;

use app\core\DbModel;

class Domain extends DbModel
{
    public int $id;
    public string $name;
    public string $label;
    public string $description;

    static public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['name', 'description', 'label'];
    }

    static public function tableName(): string
    {
        return 'domain';
    }

    public function rules(): array
    {
        return [];
    }
}