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
        try {
            if (Application::$app->db->pdo->inTransaction())
                Application::$app->db->pdo->commit();

            Application::$app->db->pdo->query('begin;');
            $stmt = DbModel::prepare(
            /** @lang PostgreSQL */
            "select get_user(:email, :password, 'user_curs');");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $fetchStmt = Application::$app->db->pdo->query('fetch all from user_curs');
            $result = $fetchStmt->fetchObject(static::class);
            Application::$app->db->pdo->query('close user_curs;');
            Application::$app->db->pdo->commit();
            return $result;
        } catch (\PDOException) {
            Application::$app->db->pdo->query('rollback;');
            return null;
        }
    }

    public static function get_user_by_id(int $id): ?User
    {
        try {
            Application::$app->db->pdo->query('begin;');
            $stmt = DbModel::prepare(
            /** @lang PostgreSQL */
            "select get_user_by_id(:id, 'user_curs');");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $fetchStmt = Application::$app->db->pdo->query('fetch all from user_curs');
            $result = $fetchStmt->fetchObject(static::class);
            Application::$app->db->pdo->query('close user_curs;');
            return $result;
        } catch (\PDOException) {
            return null;
        }
    }

    public static function get_user_by_api_key(string $apiKey): User|null
    {
        return DbModel::exec_procedure_cursor('get_user_by_api_key', [
            'api_key' => $apiKey,
        ], static::class);
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
