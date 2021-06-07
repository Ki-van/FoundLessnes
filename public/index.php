<?php
    require_once __DIR__ . "/../vendor/autoload.php";
    phpinfo();
    exit;
use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;


    $app = new Application(dirname(__DIR__));

    $app->router->get('/', [SiteController::class, 'home']);
    $app->router->post('/', function (){
        return "O";
    });

    $app->router->get('/participation', [SiteController::class, 'participation']);
    $app->router->post('/participation', [SiteController::class, 'handleParticipation']);

    $app->router->get('/login', [AuthController::class, 'login']);
    $app->router->post('/login', [AuthController::class, 'login']);

    $app->router->get('/register', [AuthController::class, 'register']);
    $app->router->post('/register', [AuthController::class, 'register']);

    $app->run();

