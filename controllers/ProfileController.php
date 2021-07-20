<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\middlewares\AuthenticationMiddleware;
use app\core\UserDescriptor;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthenticationMiddleware(UserDescriptor::GUEST, ['profile']));
    }

    public function profile()
    {
        return $this->renderView('profile');
    }

    public function sandbox()
    {
        return $this->renderView('sandbox');
    }
}
