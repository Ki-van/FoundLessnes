<?php


namespace app\core;


abstract class DbModel extends Model
{
    abstract static public function primaryKey(): string;

    abstract static public function tableName(): string;

    abstract public function attributes(): array;

    public static function findOne(array $where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode('AND ', array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    /**
     * @param string $proc_name procedure name
     * @param array $arguments arguments, exclude the cursor name
     * @param string $object object class, that must be returned
     * @return mixed /returns object from cursors first record
     */
    public static function exec_procedure_cursor(string $proc_name, array $arguments, string $object): mixed
    {
        $arguments['cursor'] = 'cursor';
        try {
            if (Application::$app->db->pdo->inTransaction())
                static::commit();
            Application::$app->db->pdo->beginTransaction();
            $stmt = static::prepare(/** @lang PostgreSQL */ "select $proc_name("
                . implode(', ', array_map(fn($arg) => ":$arg", array_keys($arguments)))
                . ")");
            foreach ($arguments as $key => $argument) {
                $stmt->bindParam(":$key", $argument);
            }
            $stmt->execute();
            $fetchStmt = Application::$app->db->pdo->query("fetch all from ".$arguments['cursor']);
            $result = $fetchStmt->fetchObject($object);
            Application::$app->db->pdo->query('close '.$arguments['cursor']);
            static::commit();
            return $result;
        } catch (\PDOException $e) {
            static::rollBack();
            return null;
        }
    }

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":" . $attr, $attributes);

        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
            VALUES (" . implode(',', $params) . ")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    public static function commit()
    {
        return Application::$app->db->pdo->commit();
    }

    public static function rollBack()
    {
        return Application::$app->db->pdo->rollBack();
    }
}