<?php

class m0001_initial
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL */ '            BEGIN;
            CREATE TABLE public."user"    
            (
                id serial NOT NULL,
                username character varying(255) NOT NULL,
                email character varying(255) NOT NULL,
                password character varying(512) NOT NULL,
                created_at timestamp without time zone,
                role_id integer NOT NULL,
                PRIMARY KEY (id)
            );
            
            CREATE TABLE public.role
            (
                id smallserial NOT NULL,
                role_name character varying(63) NOT NULL,
                PRIMARY KEY (id)
            );
            
            CREATE TABLE public.evaluable
            (
                id bigserial NOT NULL,
                PRIMARY KEY (id)
            );
            
            CREATE TABLE public.article
            (
                article_eval_id integer NOT NULL,
                heading character varying(255)[] NOT NULL,
                description character varying(512)[] NOT NULL,
                body text NOT NULL,
                author_id integer,
                created_at timestamp without time zone,
                updated_at timestamp without time zone,
                PRIMARY KEY (article_eval_id)
            );
            
            CREATE TABLE public.comment
            (
                comment_eval_id integer NOT NULL,
                body character varying(2047)[] NOT NULL,
                author_id integer,
                replay_eval_id bigint,
                created_at timestamp without time zone,
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
                article_id integer NOT NULL,
                tag_id integer NOT NULL
            );
            
            ALTER TABLE public."user"
                ADD FOREIGN KEY (role_id)
                REFERENCES public.role (id)
                NOT VALID;
            
            
            ALTER TABLE public.article
                ADD FOREIGN KEY (article_eval_id)
                REFERENCES public.evaluable (id)
                NOT VALID;
            
            
            ALTER TABLE public.article
                ADD FOREIGN KEY (author_id)
                REFERENCES public."user" (id)
                NOT VALID;
            
            
            ALTER TABLE public.comment
                ADD FOREIGN KEY (comment_eval_id)
                REFERENCES public.evaluable (id)
                NOT VALID;
            
            
            ALTER TABLE public.comment
                ADD FOREIGN KEY (author_id)
                REFERENCES public."user" (id)
                NOT VALID;
            
            
            ALTER TABLE public.comment
                ADD FOREIGN KEY (replay_eval_id)
                REFERENCES public.evaluable (id)
                NOT VALID;
            
            
            ALTER TABLE public.article_tag
                ADD FOREIGN KEY (article_id)
                REFERENCES public.article (article_eval_id)
                NOT VALID;
            
            
            ALTER TABLE public.article_tag
                ADD FOREIGN KEY (tag_id)
                REFERENCES public.tag (id)
                NOT VALID;
            
            END;
        ');
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(/** @lang PostgreSQL*/'
        DROP TABLE "user";
        DROP TABLE role;
        DROP TABLE article_tag;
        DROP TABLE comment;
        DROP TABLE tag;
        DROP TABLE evaluable;
        ');
    }
}