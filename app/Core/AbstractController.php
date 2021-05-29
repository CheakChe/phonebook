<?php


namespace App\Core;


abstract class AbstractController
{
    abstract public function index();

    public function init(): array
    {
        $data['header'] = Router::render('layouts/header', ['styles' => ['bootstrap.min', 'main.min']]);
        $data['footer'] = Router::render('layouts/footer', ['scripts' => ['main']]);

        return $data;
    }

}