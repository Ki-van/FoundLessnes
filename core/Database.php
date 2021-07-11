<?php


namespace app\core;


class Database
{
    public ?\PDO $pdo;

    /**
     * Database constructor.
     * @param array $config
     */

    public function __construct(array $config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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
        $this->pdo->exec(/** @lang PostgreSQL */"
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
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    protected function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }

    private function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
            ");
        $statement->execute();
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}