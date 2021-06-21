<?php

namespace  app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Router;

class SiteController extends Controller
{
    public function home(){
        return $this->renderView('home');
    }

    public function participation(){
        return $this->renderView('participation');
    }

    public function handleParticipation(Request $request){
        $body = $request->getBody();
        var_dump($body);

        return "Handling for shure";
    }

    public function _404() {
        return $this->renderView('_404');
    }
}