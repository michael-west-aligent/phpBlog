<?php

//require_once '../app/bootstrap.php';
require_once __DIR__ . '/../vendor/autoload.php';

//Init Core Library
//$init = new Core;

use App\Routers\Router;



//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//$dotenv->load();

$router = new Router();

$router
    ->get('/', [App\Controllers\HomeController::class, 'index'])
    ->get('/signup', [App\Controllers\SignUpController::class, 'signup'])
    ->get('/login', [App\Controllers\LoginController::class, 'login'])


    ->get('/invoices   ', [\App\Controllers\InvoiceController::class, 'create'])
    ->get('/invoices/create', [\App\Controllers\InvoiceController::class, 'create'])
    ->post('/invoices/create', [\App\Controllers\InvoiceController::class, 'create']);



echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
