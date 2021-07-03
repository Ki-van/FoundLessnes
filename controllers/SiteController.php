<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\file\UploadedFile;
use app\core\Request;
use app\core\Router;
use app\core\Session;
use app\models\Article;
use app\models\ParticipationForm;

class SiteController extends Controller
{
    public function home()
    {
        return $this->renderView('home');
    }

    public function participation(Request $request)
    {
        $participationForm = new ParticipationForm();
        if ($request->isPost()) {

            $participationForm->loadData($request->getBody());
            $participationForm->loadFiles();
            if ($participationForm->validate()) {
                $dirName = 'download\\' . date("d-m-y H.i.s");
                mkdir($dirName);
                array_map(function ($file) use ($dirName, $participationForm) {
                    /** @var UploadedFile $file */
                    $file->move($dirName);
                }, $participationForm->files);
                (new Article($participationForm->heading, $participationForm->description, $dirName, 0))->save();

                Application::$app->session->setFlash('success', 'Спасибо за участие');
                if (Application::$app->user) {
                    $url = '/profile';
                } else {
                    $url = '/';
                }
                Application::$app->response->redirect($url);


            }
        }
        return $this->renderView('participation', [
            'model' => $participationForm
        ]);
    }

    public function _404()
    {
        return $this->renderView('_404');
    }
}