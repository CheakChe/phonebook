<?php


namespace App\Controllers;


use App\Core\AbstractController;
use App\Core\Router;

class Error extends AbstractController
{

    public function index()
    {
        return Router::render('layouts/error');
    }
}