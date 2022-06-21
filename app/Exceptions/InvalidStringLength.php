<?php

namespace App\Exceptions;

class InvalidStringLength extends \Exception
{
    protected $message = 'String data, right truncated: 1406 Data too long for column';

}
