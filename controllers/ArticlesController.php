<?php


namespace app\controllers;


use app\core\Controller;
use app\core\exception\PageNotFoundException;
use app\core\Request;
use app\core\Response;
use app\core\UserModel;
use app\core\View;
use app\models\Article;
use app\models\Domain;
use app\models\User;

class ArticlesController extends Controller
{
    /**
     * @throws PageNotFoundException
     */
    public function articles(Request $request, Response $response, array $params)
    {
        if (empty($params)) {
            throw new PageNotFoundException;
        } else {
            /**
             * @var $article Article
             */
            try {
                $article = Article::findOne($params);
                return $this->renderView('articles', [
                    'model' => $article
                ]);
            } catch (\Exception $e) {
                throw new PageNotFoundException();
            }
        }
    }
}