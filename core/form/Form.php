<?php


namespace app\core\form;


use app\core\Model;

class Form
{
    static public function begin($action, $method, $enctype = ''){
        echo sprintf('<form action="%s" method="%s" enctype="%s">', $action, $method, $enctype);
        return new Form();
    }

    static public function end(){
        echo '</form>';
    }

    public function field(Model $model, $attribute){
        return new InputField($model, $attribute);
    }
}