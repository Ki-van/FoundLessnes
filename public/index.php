<?php
require_once __DIR__ . "/../vendor/autoload.php";

use app\controllers\ArticlesController;
use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;
use app\models\Article;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/participation', [SiteController::class, 'participation']);
$app->router->post('/participation', [SiteController::class, 'handleParticipation']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile', [AuthController::class, 'profile']);

$app->router->get('/articles', [ArticlesController::class, 'articles']);
$app->router->get('/articles/{url}', [ArticlesController::class, 'articles']);


$app->run();

