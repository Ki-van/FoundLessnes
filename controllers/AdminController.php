<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthorizationMiddleware;
use app\core\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthorizationMiddleware(Application::$app->userClass::ROLE_USER, ['admin']));
    }

    public function admin(Request $request)
    {
        /*if($request->isPost()) {

        }*/

        return $this->renderView('admin', [
            'model' => null,
        ]);
    }
}