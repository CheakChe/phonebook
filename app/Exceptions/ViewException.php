<?php


namespace App\Exceptions;


use Throwable;

class ViewException extends \Exception
{
    public function __construct($message = "Error with view.", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
