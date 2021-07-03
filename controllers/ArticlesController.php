<?php


namespace app\controllers;


use app\core\Controller;
use app\core\exception\PageNotFoundException;
use app\core\Request;
use app\core\Response;
use app\core\UserModel;
use app\core\View;
use app\models\Article;
use app\models\User;

class ArticlesController extends Controller
{
    public function articles(Request $request, Response $response, array $params)
    {
        if (empty($params)) {
            return $this->renderView('articles');
        } else {
            /**
             * @var $article Article
             */
            $article = Article::findOne($params);
            if($article){
                $article->author_id = User::findOne([User::primaryKey() => $article->author_id]);
                return $this->renderArticle($article->url, [
                    'model' => $article
                ]);
            } else
                throw new PageNotFoundException();
        }
    }
}