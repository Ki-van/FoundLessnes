<?php

class m0005_remove_not_null_constr_article
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(
            /** @lang PostgreSQL */
            "
                ALTER TABLE public.article ALTER COLUMN heading DROP NOT NULL;

                ALTER TABLE public.article ALTER COLUMN description DROP NOT NULL;

                ALTER TABLE public.article ALTER COLUMN stage_id SET NOT NULL;
        "
        );
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(
            /** @lang PostgreSQL*/
            '
                ALTER TABLE public.article ALTER COLUMN heading set NOT NULL;

                ALTER TABLE public.article ALTER COLUMN description set NOT NULL;

                ALTER TABLE public.article ALTER COLUMN stage_id drop NOT NULL;
        '
        );
    }
}
