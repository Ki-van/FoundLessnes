<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthenticationMiddleware;
use app\core\Request;
use app\core\Response;
use app\core\UserDescriptor;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthenticationMiddleware(UserDescriptor::NOT_GUEST,
            ['login', 'register'],
            fn() => Application::$app->response->redirect('/profile')));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');
            }
        }
        return $this->renderView('login', [
            'model' => $loginForm,
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save_user()) {
                Application::$app->session->setFlash('success', 'Регистрация прошла успешно');
                Application::$app->response->redirect('/');
            }
        }

        return $this->renderView('register', [
            'model' => $user,
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }               
}