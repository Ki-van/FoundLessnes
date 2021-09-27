<?php


namespace app\core;


abstract class DbModel extends Model
{
    abstract static public function primaryKey(): string;

    public static function findOne(array $where)
    {
        $tableName = static::tableName();
        $sql = implode('AND ',
            array_map(
                fn($attr, string $value) => "$attr = " . $value,
                array_keys($where),
                pg_convert(self::conn(), $tableName, $where)
            ));
        $result = pg_query(self::conn(), "SELECT * FROM $tableName WHERE $sql");
        return pg_fetch_object($result, null, static::class);
    }

    abstract static public function tableName(): string;

    public static function conn()
    {
        return Application::$app->db->pgsql;
    }

    public static function exec_procedure(string $proc_name, array $arguments)
    {
        $alist = [];
        for ($i = 1; $i <= count($arguments); $i++) {
            $alist[$i] = '$' . $i;
        }
        $sql = "call $proc_name" . '(' . implode(',', $alist) . ')';
        return pg_query_params(static::conn(), $sql, $arguments);
    }

    public static function selectAll(array $aColumns = null): array|bool
    {
        if (empty($aColumns))
            $columns = '*';
        else
            $columns = implode(',', $aColumns);
        $all = pg_query(self::conn(), "select {$columns} from " . static::tableName());
        if ($all)
            return pg_fetch_all($all, PGSQL_ASSOC);
        else
            return false;
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

    abstract public function attributes(): array;
}
