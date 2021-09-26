<?php


namespace app\models;


use app\core\Application;
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

    public static function findOne(array $where)
    {
        $c = Application::$app->db->pgsql;
        try {
            pg_query($c, 'Begin;');
            $isCorrect = pg_query_params($c,
                /** @lang PostgreSQL */
                "select get_article($1, 'user_curs');", array($where['article_eval_id']));
            if ($isCorrect) {
                $cursor = pg_query($c, 'fetch all from user_curs;');
                pg_query($c, 'End;');
                return pg_fetch_object($cursor, null, static::class);
            }
            else
                throw new \Exception("No article with such id or alias");
        } catch (\Exception) {
            pg_query(static::conn(), 'rollback;');
            return null;
        }
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
