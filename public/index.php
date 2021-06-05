<?php


require_once 'app/helpers/functions.php';
require_once 'app/helpers/routes.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(realpath('.'));
$dotenv->load();

session_start();
echo (new App\Core\Router)->init();
session_write_close();