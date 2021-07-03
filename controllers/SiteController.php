<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Router;
use app\core\Session;
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
            if($participationForm->validate())
            {
                Application::$app->session->setFlash('success', 'Спасибо за участие');

                if(Application::$app->user)
                {
                    $url = '/profile';
                } else
                {
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