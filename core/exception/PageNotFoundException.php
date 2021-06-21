<?php


namespace app\core\exception;


class PageNotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Страница не найдена';
}