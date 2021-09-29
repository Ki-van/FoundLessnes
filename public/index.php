<?php
require_once __DIR__ . "/../vendor/autoload.php";

use app\controllers\AdminController;
use app\controllers\ApiController;
use app\controllers\ArticlesController;
use app\controllers\AuthController;
use app\controllers\ProfileController;
use app\controllers\SiteController;
use app\core\Application;

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

/*try {
    $app = new Application(dirname(__DIR__), $config);
} catch (Exception $e) {
    http_response_code(502);
    echo '<h1>502</h1>';
    die();
}*/
$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile', [ProfileController::class, 'profile']);
$app->router->get('/profile/sandbox', [ProfileController::class, 'sandbox']);


$app->router->get('/articles', [ArticlesController::class, 'articles']);
$app->router->get('/articles/{article_eval_id}', [ArticlesController::class, 'articles']);

$app->router->get('/admin', [AdminController::class, 'admin']);
$app->router->post('/admin', [AdminController::class, 'admin']);

$app->router->get('/admin/statistic', [AdminController::class, 'statistic']);
$app->router->get('/admin/articles', [AdminController::class, 'articles']);


$app->router->post('/api/uploadFile', [ApiController::class, 'uploadFile']);
$app->router->post('/api/uploadByUrl', [ApiController::class, 'uploadByUrl']);

/**
 * @var $method - update, create
 */
$app->router->post('/api/article/{method}', [ApiController::class, 'article']);



$app->run();

