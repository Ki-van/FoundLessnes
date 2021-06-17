<?php

class m0001_initial
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            password VARCHAR(512) NOT NULL ,
            status TINYINT NOT NULL ,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;
        ");
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("
        DROP TABLE users;
        ");
    }
}