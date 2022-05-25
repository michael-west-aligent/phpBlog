<?php

declare(strict_types=1);

namespace App\Controllers;


use App\View;

class InvoiceController
{
    public function index(): View
    {
        echo $_POST['username'];
        return View::make('index');

    }

    public function create(): string
    {
        return '<form action"/invoice/create" method="post"><label>UserName </label><input type="text" name="username"/>
<button type="submit"> YAY</button> 
</form
>';
    }


//
//    public function store()
//    {
//        $username = $_POST['username'];
//        var_dump($username);
//    }
}