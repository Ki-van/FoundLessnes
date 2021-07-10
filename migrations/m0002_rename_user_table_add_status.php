<?php


class m0002_rename_user_table_add_status
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL */ ' 
        create table user_statuses (
          user_status_id smallserial primary key not null,
          user_status varchar(63) not null 
        );
        
        insert into user_statuses (user_status) values (\'active\'), (\'deleted\'), (\'banned\');

        alter table "user" rename to users;
        alter table users add column status_id integer not null default 1 references user_statuses(user_status_id) on delete restrict;

    ');
    }

    public function down()
    {

        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL*/'
        alter table users drop column status_id;
        alter table users rename to "user"; 
        drop table user_statuses;
        ');
    }
}