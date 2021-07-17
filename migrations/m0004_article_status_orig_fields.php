<?php

class m0004_article_status_orig_fields
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL */ "
            create table article_statuses(
                id smallserial primary key not null,
                article_status varchar(32) not null unique
            );
            insert into article_statuses (article_status) values ('published'), ('moderated'), ('hidden'), ('deleted') ; 
                
            alter table article add column stage_id int references article_statuses(id);
        ");
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL*/'
           drop table if exists article_statuses;
           alter table article drop column if exists stage_id;
        ');
    }
}