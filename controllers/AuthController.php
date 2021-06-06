<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isPost()) {
            return "Handling login post";
        }
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if ($request->isPost()) {
            return "Handling register post";
        }

        return $this->render('register');
    }
}