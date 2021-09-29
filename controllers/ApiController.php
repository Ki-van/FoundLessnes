<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\exception\ForbiddenException;
use app\core\file\UploadedImage;
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
                ['uploadFile', 'uploadByUrl', 'article'],
                fn () => Application::$app->response->setStatusCode(Response::HTTP_UNAUTHORIZED)
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
        //TODO: upload by url
        $response->setStatusCode(Response::HTTP_NOT_IMPLEMENTED);
    }

    public function article(Request $request, Response $response, array $params)
    {
        $article = new Article();
        $data = $request->getJsonData();
        $article->loadData($data);

        if(true || $article->validate()){
            switch ($params['method'])
            {
                case 'create': {
                    $article->author_id = Application::$app->user->id;
                    if($article->save())
                        $response->setStatusCode(Response::HTTP_OK);
                    else
                        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                } break;
                case 'update': {
                    if ($article->update() == 1) {
                        $response->setStatusCode(Response::HTTP_OK);
                    } else
                        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                } break;
                default:
                    $response->setStatusCode(Response::HTTP_NOT_FOUND);
                    return;
            }
        } else {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->sendJson($article->errors);
        }
    }
}
