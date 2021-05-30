<?php


namespace App\Core;


use App\Controllers\FooterController;
use App\Controllers\HeaderController;
use App\Exceptions\ViewException;

abstract class AbstractController
{
    abstract public function index();

    /**
     * @throws ViewException
     */
    public function init(): array
    {
        $data['header'] = (new HeaderController)->index();
        $data['footer'] = (new FooterController)->index();

        return $data;
    }

}