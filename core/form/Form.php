<?php


namespace app\core\form;


use app\core\Model;

class Form
{
    static public function begin($action, $method){
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    static public function end(){
        echo '</form>';
    }

    public function field(Model $model, $attribute){
        return new Field($model, $attribute);
    }
}