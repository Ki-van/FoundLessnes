<?php

class m0002_create_articles_table
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("
        CREATE TABLE articles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            author_id VARCHAR(255) REFERENCES users (id) ON DELETE SET NULL,
            heading VARCHAR(255) NOT NULL,
            url VARCHAR(512) NOT NULL,
            description VARCHAR(512) NOT NULL ,
            status_code INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ");
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("
        DROP TABLE articles;
        ");
    }
}