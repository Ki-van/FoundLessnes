<?php

namespace  app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Router;

class SiteController extends Controller
{
    public function home(){
        $params = [
            'title' => 'Foundlessness'
        ];
        return $this->render('home', $params);
    }

    public function participation(){
        $params = [
            'title' => 'Участие'
        ];
        return $this->render('participation', $params);
    }

    public function handleParticipation(Request $request){
        $body = $request->getBody();
        var_dump($body);
        exit;
        return "Handling for shure";
    }

    public function _404() {
        $params = [
            'title' => 'Страница не найдена'
        ];
        return $this->render('_404', $params);
    }

}