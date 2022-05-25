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
    ->get('/signup', [\App\Controllers\SignUpController::class, 'signup'])
    ->get('/login', [\App\Controllers\LoginController::class, 'login'])
    ->get('/invoices', [\App\Controllers\InvoiceController::class, 'invoices'])
    ->get('/invoices/create', [\App\Controllers\InvoiceController::class, 'create'])
    ->post('/invoices/create', [\App\Controllers\InvoiceController::class, 'index']);


//echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config\Config($_ENV)
))->run();


