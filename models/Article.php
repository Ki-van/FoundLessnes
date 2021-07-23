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
    public int $stage_name = self::MODERATION;
    public  $created_at;
    public  $changed_at;


    public function __construct()
    {
    }


    public function save(): bool
    {

        return true;
    }

    public function saveCreating()
    {

        return DbModel::exec_procedure('add_article', [
            'author_id' => $this->author_id,
            'body' => $this->body
        ]);
    }

    static public function primaryKey(): string
    {
        return 'article_eval_id';
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
        return ['article_eval_id', 'heading', 'description', 'body'];
    }

    public function labels(): array
    {
        return ['heading' => 'Заголовок', 'description' => 'Описание'];
    }
}
