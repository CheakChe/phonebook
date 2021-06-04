<?php


namespace App\Controllers;


use App\Core\AbstractController;
use App\Exceptions\ViewException;

class FooterController extends AbstractController
{

    /**
     * @throws ViewException
     */
    public function index(): bool|string
    {
        return view('layouts/footer', ['scripts' => ['index.min']]);
    }
}
