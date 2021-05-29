<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(realpath('.'));
$dotenv->load();

session_start();
(new App\Core\Router)->init();
session_write_close();

/**
 * Возвращает переменную из файла .env
 *
 * @param string $key Ключ
 * @return string|null
 */
function env(string $key): ?string
{
    return $_ENV[$key] ?? NULL;
}