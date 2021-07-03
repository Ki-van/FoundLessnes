<?php


namespace app\models;


use app\core\DbModel;

class Article extends DbModel
{
    const STATUS_CODE_PUBLISHED = 1;
    const STATUS_CODE_MODERATION = 2;


    public int $id = 0;
    public string $heading = '';
    public string $description = '';
    public string $url = '';
    public int $status_code = self::STATUS_CODE_MODERATION;
    public ?int $author_id = 0;
    public  $created_at;
    public  $changed_at;

    /**
     * Article constructor.
     * @param string $heading
     * @param string $description
     * @param string $url
     * @param int $author_id
     */
    public function __construct(string $heading, string $description, string $url, int $author_id = 0, $status_code = self::STATUS_CODE_MODERATION)
    {
        $this->heading = $heading;
        $this->description = $description;
        $this->url = $url;
        $this->author_id = $author_id;
    }


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
        return ['id', 'heading', 'description', 'url', 'author_id', 'status_code'];
    }


}