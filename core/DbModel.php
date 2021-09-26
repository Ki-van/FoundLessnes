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
        $sql = implode('AND ',
            array_map(
                fn ($attr, string $value) =>
                    "$attr = ".$value,
                array_keys($where),
                pg_convert(self::conn(), $tableName, $where)
            ));
        $result = pg_query(self::conn(), "SELECT * FROM $tableName WHERE $sql");
        return pg_fetch_object($result, null, static::class);
    }

    /**
     * @param string $proc_name procedure name
     * @param array $arguments arguments, exclude the cursor name, numeric keys, corresponding to arguments order
     * @param string $object object class, that must be returned
     * @return mixed /returns object from cursors first record
     */
    public static function exec_procedure_cursor(string $proc_name, array $arguments, string $object): mixed
    {
        $arguments['cursor'] = 'cursor';
        try {
            $stmt = static::prepare(
            /** @lang PostgreSQL */
            "select $proc_name("
                . implode(', ', array_map(fn ($arg) => ":$arg", array_keys($arguments)))
                . ")");
            foreach ($arguments as $key => $argument) {
                $stmt->bindParam(":$key", $argument);
            }
            $stmt->execute();
            $fetchStmt = Application::$app->db->pdo->query("fetch all from " . $arguments['cursor']);
            $result = $fetchStmt->fetchObject($object);
            Application::$app->db->pdo->query('close ' . $arguments['cursor']);
            static::commit();
            return $result;
        } catch (\PDOException $e) {
            static::rollBack();
            return null;
        }
    }

    public static function exec_procedure(string $proc_name, array $arguments)
    {
        $alist = [];
        for($i = 1; $i <= count($arguments); $i++) {
            $alist[$i] = '$' . $i;
        }
        $sql = "call $proc_name" . '(' . implode(',', $alist) . ')';
        return pg_query_params(static::conn(), $sql, $arguments);
    }

    public function save()
    {
        $attributes = $this->attributes();
        $assoc_array = [];
        foreach ($attributes as $attribute) {
            $assoc_array[$attribute] = $this->{$attribute};
        }

       return pg_insert($this->conn(), $this->tableName(), $assoc_array);
    }

    public static function selectAll()
    {
        $all = pg_query(self::conn(), "select * from ".static::tableName());
        return pg_fetch_all($all, PGSQL_ASSOC);
    }

    public static function conn()
    {
        return Application::$app->db->pgsql;
    }
}
