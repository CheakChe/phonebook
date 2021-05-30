<?php


namespace App\Exceptions;


use Throwable;

class RouterException extends \Exception
{
    public function __construct($message = "Error with router.", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
