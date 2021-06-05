<?php


namespace App\Controllers;


use App\Core\AbstractController;
use App\Exceptions\ViewException;

class HeaderController extends AbstractController
{

    /**
     * @throws ViewException
     */
    public function index(): bool|string
    {
        return view('layouts/header', ['styles' => ['index.min']]);
    }
}
