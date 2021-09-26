<?php

namespace app\core;

use app\core\exception\PageNotFoundException;
use app\models\Visit;
use Exception;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public Controller $controller;
    public ?UserModel $user;
    public View $view;

    public function __construct($root_dir, array $config)
    {
        self::$ROOT_DIR = $root_dir;
        self::$app = $this;

        $this->userClass = $config['userClass'];
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->view = new View();


        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $this->user = $this->userClass::get_user_by_id($primaryValue);
        } else {
            $apiKey = $this->request->getHeader('x-api-key');
            if ($apiKey)
                $this->user = $this->userClass::get_user_by_api_key($apiKey);
            else
                $this->user = null;
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    public static function isAdmin(): bool
    {
        if(self::$app->user != null)
            return self::$app->user->role_name === self::$app->userClass::ROLE_ADMIN;
        else
            return false;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (PageNotFoundException $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_404');
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $this->session->set('user', $user->{$primaryKey});

        if (!$_COOKIE['api_key'])
            setcookie('api_key', $this->user->api_key,);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public function __destruct()
    {
        if($this->request->isGet()) {
            $visit = new Visit($this->request);
            $visit->save();
        }
    }
}
