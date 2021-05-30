<?php

require_once 'app/Core/routes.php';
require_once 'app/Core/helpers.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(realpath('.'));
$dotenv->load();

session_start();
(new App\Core\Router)->init();
session_write_close();