<?php


namespace app\models;


use app\core\Application;
use app\core\DbModel;
use app\core\interfaces\uniqueAttributesI;

class Article extends DbModel implements uniqueAttributesI
{
    public const STATUS_MODERATED = 2;

    public string $article_eval_id = "";
    public string $heading = '';
    public string $description = '';
    public string $author_id = '';
    public string $alias = '';
    public int $status_id = self::STATUS_MODERATED;
    public string $article_status;
    public array $tag_ids = [];
    public int $domain_id = 0;
    public  $created_at;
    public  $changed_at;
    public string $body =
        '{
        "blocks": [
            {
                "type": "header",
                "data": {
                    "text": "Заголовок",
                    "level": 1
                }
            },
            {
                "type": "paragraph",
                "data": {
                    "text": "Содержание публикации"
                }
            }
        ],
    }';

    static public function primaryKey(): string
    {
        return 'article_eval_id';
    }
    public static function uniques(): array
    {
        return ['article_eval_id', 'alias'];
    }

    public function save()
    {
        return DbModel::exec_procedure('add_article',
            array($this->author_id,
                $this->heading,
                $this->description,
                $this->body,
                $this->status_id,
                '{'.implode(', ', $this->tag_ids).'}',
                $this->domain_id)
        );
    }

    public static function findOne(array $where)
    {
        try {
            $result = pg_query_params(self::connection(),
                /** @lang PostgreSQL */"select 
      article_eval_id, heading, description, body, author_id, created_at, updated_at, status_id, alias, article_status
        from public.article, article_statuses 
        where  id = article.status_id 
          and (article_eval_id = $1 or alias = $1) 
            limit 1",
                array($where['article_eval_id']));

            if ($result) {
                return pg_fetch_object($result, null, static::class);
            }
            else
                throw new \Exception("No article with such id or alias");
        } catch (\Exception $e) {
            pg_query(static::connection(), 'rollback;');
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
        return ['heading', 'description', 'body', 'author_id', 'status_id', 'alias'];
    }

    public function labels(): array
    {
        return [
            'heading' => 'Заголовок',
            'description' => 'Описание',
            'alias' => 'Псевдоним',
            'article_status' => 'Статус публикации',
            'tag_ids' => 'Теги',
            'domain_id' => 'Область знания'
        ];
    }
}
