<?php


namespace app\models;


use app\core\Application;
use app\core\DbModel;
use app\core\UserModel;

class User extends UserModel
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    const STATUS_BANNED = 'banned';

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';


    public string $id = '';
    public string $username = '';
    public string $email = '';
    public string $created_at = '';
    public string $role_name = '';
    public string $user_status = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public string $api_key = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public function save_user(): bool
    {
        $stmt = DbModel::prepare(
        /** @lang PostgreSQL */
        'call add_user(:username, :email, :password, :role, :id)');
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindValue(':role', self::ROLE_USER);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT | \PDO::PARAM_INPUT_OUTPUT, 12);
        $stmt->execute();

        return true;
    }

    public static function get_user(string $email, string $password): ?User
    {
        $c = Application::$app->db->pgsql;
        try {
            pg_query($c, 'Begin;');
            $status = pg_transaction_status($c);
            pg_query_params($c,
            /** @lang PostgreSQL */
            "select get_user($1, $2, 'user_curs');", array($email, $password));
            $cursor =  pg_query($c, 'fetch all from user_curs;');
            pg_query($c, 'End;');
            $status = pg_transaction_status($c);
            $result = pg_fetch_object($cursor, null, static::class);

            return $result;
        } catch (\PDOException) {
            pg_query(Application::$app->db->pgsql, 'close user_curs; rollback;');
            return null;
        }
    }

    public static function get_user_by_id(int $id): ?User
    {
        $c = Application::$app->db->pgsql;
        try {
            pg_query($c, 'Begin;');
            pg_query_params($c,
                /** @lang PostgreSQL */
                "select get_user_by_id($1, 'user_curs');", array($id));
            $cursor =  pg_query($c, 'fetch all from user_curs;');
            pg_query($c, 'End;');
            $result = pg_fetch_object($cursor, null, static::class);

            return $result;
        } catch (\PDOException) {
            return null;
        }
    }

    public static function get_user_by_api_key(string $apiKey): User|null
    {
        return DbModel::exec_procedure_cursor('get_user_by_api_key', [$apiKey], static::class);
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes(): array
    {
        return ['username', 'email', 'password', 'role_name', 'user_status'];
    }

    public function labels(): array
    {
        return [
            'username' => 'Имя',
            'email' => 'Почта',
            'password' => 'Пароль',
            'passwordConfirm' => 'Подтвердите пароль'
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplayName(): string
    {
        return $this->username;
    }
}
