<?php

declare(strict_types=1);

namespace App\Controllers;

class InvoiceController
{
    public function index(): string
    {
        return 'Invoices';
    }

    public function create(): string
    {
        return '<form action"/invoice/create" method="get"><label>UserName </label><input type="text" name="username"/> </></form>';
    }


    public function store()
    {
        $username = $_POST['username'];
        var_dump($username);
    }
}