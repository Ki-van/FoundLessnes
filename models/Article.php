<?php


namespace app\models;


use app\core\DbModel;

class Article extends DbModel
{
    const PUBLISHED = 1;
    const MODERATION = 2;
    const CREATING = 3;

    public int $article_eval_id = 0;
    public string $heading = '';
    public string $description = '';
    public string $body = '';
    public string $author_id = '';
    public int $status_id;
    public string $article_status;
    public  $created_at;
    public  $changed_at;


    public function __construct()
    {
    }

    static public function primaryKey(): string
    {
        return 'article_eval_id';
    }

    public function save()
    {
        return DbModel::exec_procedure('add_article',
            array($this->author_id, $this->heading, $this->description, $this->body, $this->article_status));
    }


    static public function tableName(): string
    {
        return 'article';
    }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return ['article_eval_id', 'heading', 'description', 'body', 'author_id', 'status_id'];
    }

    public function labels(): array
    {
        return ['heading' => 'Заголовок', 'description' => 'Описание'];
    }
}
