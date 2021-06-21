<?php


namespace app\models;


use app\core\DbModel;
use app\core\Model;

class Article extends DbModel
{
    public int $id = 0;
    public string $heading = '';
    public string $description = '';
    public string $url = '';
    public  $author;
    public  $created_at;
    public  $changed_at;

    static public function primaryKey(): string
    {
        return 'id';
    }

    static public function tableName(): string
    {
        return 'articles';
    }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return ['id', 'heading', 'description', 'author'];
    }


}