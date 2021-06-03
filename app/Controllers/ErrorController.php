<?php


namespace App\Controllers;


use App\Core\AbstractController;
use App\Exceptions\ViewException;

class ErrorController extends AbstractController
{

    /**
     * @throws ViewException
     */
    public function index(): bool|string
    {
        return view('layouts/error');
    }
}