<?php

use App\Core\View;
use App\Exceptions\ViewException;

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

/**
 * Упрощённый доступ к формированию шаблона.
 *
 * @param string $template Путь к шаблону.
 * @param string|array|null $properties Свойства необходимые в шаблоне.
 * @return bool|string
 * @throws ViewException
 */
function view(string $template, string|array|null $properties = NULL): bool|string
{
    return (new View)->render($template, $properties);
}
