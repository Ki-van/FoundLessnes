<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;

class AdminConroller extends Controller
{

    public function admin(Request $request)
    {
        /*if($request->isPost()) {

        }*/

        return $this->renderView('admin', [
            'model' => null,
        ]);
    }
}