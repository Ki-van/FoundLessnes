<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\exception\ForbiddenException;
use app\core\file\UploadedImage;
use app\core\middlewares\ApiMiddleware;
use app\core\middlewares\AuthenticationMiddleware;
use app\core\Request;
use app\core\Response;
use app\core\UserDescriptor;
use app\models\Article;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(
            new AuthenticationMiddleware(
                UserDescriptor::GUEST,
                ['uploadFile', 'uploadByUrl', 'save', 'article'],
                fn () => Application::$app->response->sendJson(['success' => 0,])
            )
        );
    }

    public function uploadFile(Request $request, Response $response)
    {
        try {
            $uploadedImage = new UploadedImage($request->getFirstFile('image'));
            if ($uploadedImage->validate()) {

                $filename = 'i_' . uniqid(time()) . '.' . pathinfo($uploadedImage->name, PATHINFO_EXTENSION);
                $uploadedImage->move('images\\article', $filename);
                $response->sendJson(
                    [
                        'success' => 1,
                        'file' => [
                            'url' => "http://localhost:8000/images/article/$filename"
                        ]
                    ]
                );
            } else
                throw  new \Exception();
        } catch (\Exception $e) {
            $response->sendJson(['success' => 0]);
        }
    }

    public function uploadByUrl(Request $request, Response $response)
    {
    }

    public function article(Request $request, Response $response)
    {
        //TODO: validation
        $article = new Article();
        $article->body = json_encode($request->getJsonData()->article);
        $article->author_id = Application::$app->user->id;


        if($article->saveCreating()){
            $response->sendJson(['success' => 1]);
        } else
            $response->sendJson(['success' => 0]);

    }
}
