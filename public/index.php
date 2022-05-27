<?php

//require_once '../app/bootstrap.php';
require_once __DIR__ . '/../vendor/autoload.php';

//Init Core Library
//$init = new Core;

use App\Config\App;
use App\Config\Config;
use App\Routers\Router;
use App\Controllers\HomeController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);


$dotenv->load();

const VIEW_PATH = __DIR__ . '/../app/Views';

$router = new Router();

$router
    ->get('/', [\App\Controllers\HomeController::class, 'home'])
//    ->get('/login', [\App\Controllers\LoginController::class, 'login'])
    ->get('/users/login', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/users/register', [\App\Controllers\UsersController::class, 'register'])
    ->post('/users/register', [\App\Controllers\UsersController::class, 'register']);


/** MORE ROUTES
 * users/register
 * users/login
 */


(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config\Config($_ENV)
))->run();


