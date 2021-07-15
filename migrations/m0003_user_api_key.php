<?php

class m0003_user_api_key
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL */ '
            alter table users add column api_key varchar(40)  not null unique default random();
            update users set api_key = generate_uniq_api_key(16);
            alter table users alter column api_key set default generate_uniq_api_key(16);
        ');
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL*/'
            alter table users drop column api_key;
        ');
    }
}