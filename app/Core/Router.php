<?php

namespace App\Core;

use App\Controllers\ErrorController;
use App\Exceptions\RouterException;

/**
 * @method static get(string $url, array $action)
 * @method static post(string $url, array $action)
 * @method static put(string $url, array $action)
 * @method static patch(string $url, array $action)
 * @method static delete(string $url, array $action)
 */
class Router
{
    private string $url;
    private string $httpMethod;
    private bool $isAjax;
    private static array $paths = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->isAjax = array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @throws RouterException
     */
    public function init(): void
    {
        if (!array_key_exists($this->url, self::$paths[$this->httpMethod])){
            $this->isAjax ? throw new RouterException('Такого пути не существует.') : $this->error();
        }

        $this->router();
    }

    private function router(): void
    {
        try {
            $controller = new self::$paths[$this->httpMethod][$this->url]['controller'];
            $method = self::$paths[$this->httpMethod][$this->url]['method'];

            $vars['content'] = $controller->$method();

            if(!$this->isAjax){
                $vars[] = $controller->init();
                $this->view($vars);
            }
        }catch (\Throwable $error){
            die(Log::writeLog($error->getMessage()));
        }
    }

    private function error()
    {
        $error = new ErrorController;
        $vars[] = $error->init();
        $vars['content'] = $error->index();
        $this->view($vars);
        die;
    }

    private function view($vars): void
    {
        $vars = $this->var($vars);
        include_once './public/index.php';
    }

    private function var($vars)
    {
        foreach ($vars as $key => $var) {
            if (is_array($var)) {
                foreach ($var as $key2 => $var_one) {
                    $data[$key2] = $var_one;
                }
            } else {
                $data[$key] = $var;
            }
        }
        return $data;
    }

    /**
     * Добавление пути в Router.
     *
     * @param string $name Название функции.
     * @param array $arguments Параметры передаваемые в неё. Пример: '/', [Controller::class, 'index'].
     * @option string $arguments[0] Путь.
     * @option string $arguments[1][0] Контроллер для запуска.
     * @option ?string $arguments[1][1] Вызываемый метод. По умолчанию: index.
     * @return void
     * @throws RouterException
     */
    public static function __callStatic(string $name, array $arguments): void
    {
        $name = mb_strtoupper($name);

        if(!array_key_exists($name, self::$paths)){
            throw new RouterException("Не существует такого HTTP метода: $name");
        }
        if(!is_array($arguments[1])){
            throw new RouterException('Отсутствуют данные для запуска пути.');
        }
        if(!array_key_exists(0, $arguments[1])){
            throw new RouterException('Отсутствует контроллер для запуска пути.');
        }

        $path = $arguments[0] ?: '/';
        $controller = $arguments[1][0];
        $method = $arguments[1][1] ?? 'index';

        self::$paths[$name][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

}
