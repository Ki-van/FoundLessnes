<?php

namespace  app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Router;
use app\models\ParticipationForm;

class SiteController extends Controller
{
    public function home(){
        return $this->renderView('home');
    }

    public function participation(Request $request){
        $participationForm = new ParticipationForm();
        if($request->isGet()) {
            return $this->renderView('participation', [
                'model' => $participationForm
            ]);
        }
        else {
            $participationForm->loadData(array_merge($request->getBody(), $_FILES));

        }
    }

    public function _404() {
        return $this->renderView('_404');
    }
}