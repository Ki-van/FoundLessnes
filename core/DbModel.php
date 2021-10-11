<?php


namespace app\core;


use app\core\interfaces\uniqueAttributesI;

abstract class DbModel extends Model
{
    abstract static public function primaryKey(): string;

    abstract public function attributes(): array;

    abstract static public function tableName(): string;

    public static function findOne(array $where)
    {
        $tableName = static::tableName();
        $sql = implode('AND ',
            array_map(
                fn($attr, string $value) => "$attr = " . $value,
                array_keys($where),
                pg_convert(self::connection(), $tableName, $where)
            ));
        $result = pg_query(self::connection(), "SELECT * FROM $tableName WHERE $sql");
        return pg_fetch_object($result, null, static::class);
    }

    public static function connection()
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
        return pg_query_params(static::connection(), $sql, $arguments);
    }

    public static function selectAll(array $aColumns = null): array|bool
    {
        if (empty($aColumns))
            $columns = '*';
        else
            $columns = implode(',', $aColumns);
        $all = pg_query(self::connection(), "select {$columns} from " . static::tableName());
        if ($all)
            return pg_fetch_all($all, PGSQL_ASSOC);
        else
            return false;
    }

    public static function select(array $where)
    {
        $tableName = static::tableName();
        $sql = implode('AND ',
            array_map(
                fn($attr, string $value) => "$attr = " . $value,
                array_keys($where),
                pg_convert(self::connection(), $tableName, $where)
            ));
        $result = pg_query(self::connection(), "SELECT * FROM $tableName WHERE $sql");
        return pg_fetch_all($result, PGSQL_ASSOC);
    }

    public function save()
    {
        $attributes = $this->attributes();
        $assoc_array = [];
        foreach ($attributes as $attribute) {
            $assoc_array[$attribute] = $this->{$attribute};
        }

        return pg_insert($this->connection(), $this->tableName(), $assoc_array);
    }

    public function update(): bool
    {
        $attributes = $this->attributes();
        $sql = pg_update(self::connection(), static::tableName(),
            array_combine(
                $attributes,
                array_map(
                    fn($attr) => $this->{$attr},
                    $attributes
                )
            ),
            [static::primaryKey() => $this->{static::primaryKey()}],PGSQL_DML_STRING
        );
       $result = pg_query(self::connection(),
           preg_replace('/("[a-zA-Z\d_]+"=NULL[,]?)/i', '', $sql)
       );
        if($result)
            return pg_affected_rows($result);
        else
            return false;
    }
}
