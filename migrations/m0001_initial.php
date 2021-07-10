<?php

class m0001_initial
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL */ '
            BEGIN;
             CREATE TABLE public.role
            (
                id smallserial NOT NULL,
                role_name character varying(63) NOT NULL,
                PRIMARY KEY (id)
            );
            
            insert into  public.role (role_name) values (\'Администратор\'), (\'Пользователь\');

            CREATE TABLE public."user"    
            (
                id serial NOT NULL,
                username character varying(255) NOT NULL,
                email character varying(255) NOT NULL,
                password character varying(512) NOT NULL,
                created_at timestamp(0) without time zone NOT NULL default LOCALTIMESTAMP(0),
                role_id integer NOT NULL REFERENCES public.role (id) ON DELETE RESTRICT,
                PRIMARY KEY (id)
            );
            
           

            CREATE TABLE public.evaluable
            (
                id bigserial NOT NULL,
                PRIMARY KEY (id)
            );
            
            CREATE TABLE public.article
            (
                article_eval_id integer NOT NULL references public.evaluable (id) on DELETE restrict on update cascade,
                heading character varying(255)[] NOT NULL,
                description character varying(512)[] NOT NULL,
                body text NOT NULL,
                author_id integer REFERENCES public."user" (id) on delete set null on update cascade,
                created_at timestamp(0) without time zone NOT NULL default LOCALTIMESTAMP(0),
                updated_at timestamp(0) without time zone NOT NULL default LOCALTIMESTAMP(0),
                PRIMARY KEY (article_eval_id)
            );
            
            CREATE TABLE public.comment
            (
                comment_eval_id integer NOT NULL REFERENCES public.evaluable (id) on delete restrict ,
                body character varying(2047)[] NOT NULL,
                author_id integer  REFERENCES public."user" (id) on delete set null ,
                replay_eval_id bigint REFERENCES public.evaluable (id) on delete restrict ,
                created_at timestamp(0) without time zone NOT NULL default LOCALTIMESTAMP(0),
                PRIMARY KEY (comment_eval_id)
            );
            
            CREATE TABLE public.tag
            (
                id smallserial NOT NULL,
                tag_name character varying(63)[] NOT NULL,
                PRIMARY KEY (id)
            );
            
            CREATE TABLE public.article_tag
            (
                article_id integer NOT NULL REFERENCES public.article (article_eval_id) on delete cascade,
                tag_id integer NOT NULL  REFERENCES public.tag (id) on delete restrict,
                primary key (article_id, tag_id)
            );
            
            create table public.marks
            (
              evaluable_id bigint not null references public.evaluable (id),
              author_id integer  REFERENCES public."user" (id) on delete set null,
              mark integer not null check ( mark in(-1, 1) ),
              primary key (evaluable_id, author_id)
            );

            END;
        ');
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL*/'
        DROP SCHEMA public;
        ');
    }
}