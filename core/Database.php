<?php


namespace app\core;


use mysql_xdevapi\Exception;

class Database
{
    /**
     * @var false|resource
     */
    public $pgsql;
    /**
     * Database constructor.
     * @param array $config
     */

    public function __construct(array $config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];
        $this->pgsql = pg_connect($dsn." user=".$user." password=".$password);

        if(!$this->pgsql){
            throw new Exception("Failed to connect to the postgres db");
        }

    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = scandir(Application::$ROOT_DIR . '/migrations');

        $toApplyMigrations = array_diff($files, $appliedMigrations);

        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..')
                continue;

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Applying migration $migration");
            $instance->up();
            $newMigrations[] = $migration;

        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else
            $this->log("All migrations are applied");
    }

    public function createMigrationsTable()
    {
        pg_query($this->pgsql, /** @lang PostgreSQL */"
        CREATE TABLE IF NOT EXISTS migrations (
            id smallserial NOT NULL,
            migration character varying(255),
            created_at timestamp(0) without time zone NOT NULL default LOCALTIMESTAMP(0),
            PRIMARY KEY (id)
        );
        ");
    }

    private function getAppliedMigrations(): array
    {
        $migrations = pg_query($this->pgsql, "SELECT migration FROM migrations");
        return pg_fetch_all($migrations);
    }

    protected function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }

    private function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        pg_query($this->pgsql, "INSERT INTO migrations (migration) VALUES $str");
    }

    public function __destruct()
    {
        //pg_close($this->pgsql);
    }
}