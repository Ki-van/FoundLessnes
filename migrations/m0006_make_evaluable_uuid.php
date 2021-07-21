<?php

class m0005_remove_not_null_constr_article
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(
            /** @lang PostgreSQL */
            "
            ALTER TABLE public.comment DROP CONSTRAINT comment_comment_eval_id_fkey;
            ALTER TABLE public.comment DROP CONSTRAINT comment_replay_eval_id_fkey;
            ALTER TABLE article_tag DROP CONSTRAINT article_tag_article_id_fkey;
            ALTER TABLE article DROP CONSTRAINT article_article_eval_id_fkey;
            ALTER TABLE marks DROP CONSTRAINT marks_evaluable_id_fkey;    

            alter table evaluable drop column evaluable.id;
            alter table evaluable add column 'id' VARCHAR(40) PRIMARY key;
            ALTER TABLE public.article
                ADD CONSTRAINT article_id_fk FOREIGN KEY (article_eval_id)
                REFERENCES public.evaluable (id)
                ON UPDATE CASCADE
                ON DELETE RESTRICT
                NOT VALID;

            alter table article_tag alter column article_id set data type varchar(40);
                ALTER TABLE public.article_tag
                    ADD CONSTRAINT article_id_fk FOREIGN KEY (article_id)
                    REFERENCES public.evaluable (id)
                    ON UPDATE CASCADE
                    ON DELETE RESTRICT;

            
            alter table public.comment alter column comment_eval_id set data type varchar(40);
            alter table public.comment alter column replay_eval_id set data type varchar(40);

            ALTER TABLE public.comment
                ADD CONSTRAINT comment_id_fk FOREIGN KEY (comment_eval_id)
                REFERENCES public.evaluable (id)
                ON UPDATE CASCADE
                ON DELETE RESTRICT;
                
            ALTER TABLE public.comment
                ADD CONSTRAINT replay_id_fk FOREIGN KEY (replay_eval_id)
                REFERENCES public.evaluable (id)
                ON UPDATE CASCADE
                ON DELETE RESTRICT; 

            alter table marks alter column evaluable_id set data type varchar(40);
            ALTER TABLE public.marks
                ADD CONSTRAINT eval_id_fk FOREIGN KEY (evaluable_id)
                REFERENCES public.evaluable (id)
                ON UPDATE CASCADE
                ON DELETE RESTRICT;
            "
        );
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec(
            /** @lang PostgreSQL*/
            '
             next time  
            '
        );
    }
}
