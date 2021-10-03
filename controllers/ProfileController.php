<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\middlewares\AuthenticationMiddleware;
use app\core\UserDescriptor;
use app\models\Article;
use app\core\Application;

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

    public function sandbox(Request $request)
    {
        $article = new Article();

        return $this->renderView('sandbox', [
            'model' => $article
        ]);
    }
}
