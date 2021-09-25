<?php

class m0007_visits_table
{
    public function up()
    {
        $db = \app\core\Application::$app->db->pgsql;
        pg_query($db, "create table public.visits(
            id serial NOT NULL PRIMARY KEY,
            ip varchar(46) NOT NULL,
            user_agent varchar(128),
            page varchar(64)
        );");
    }

    public function down()
    {
        $db = \app\core\Application::$app->db->pgsql;
        pg_query($db, "
            drop table public.visits;
        ");
    }
}
