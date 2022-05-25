<?php

namespace App\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = 'page not found';

}