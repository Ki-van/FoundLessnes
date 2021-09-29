<?php


namespace app\models;


use app\core\Application;
use app\core\DbModel;

class ArticleStatuses extends DbModel
{
    public int $id;
    public string $article_status;

    static public function primaryKey(): string
    {
        return 'id';
    }

    static public function uniques(): array
    {
        return ['id'];
    }

    static public function tableName(): string
    {
        return 'article_statuses';
    }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return ['id', 'article_status'];
    }
}
