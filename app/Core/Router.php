<?php


namespace App\Core;


use App\Controllers\ErrorController;
use App\Exceptions\RouterException;
use App\Exceptions\ViewException;

/**
 * @method static get(string $url, array $action)
 * @method static post(string $url, array $action)
 * @method static put(string $url, array $action)
 * @method static patch(string $url, array $action)
 * @method static delete(string $url, array $action)
 */
class Router
{
    private static array $paths = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];
    private string $url;
    private string $httpMethod;
    private bool $isAJAX;

    public function __construct()
    {
        $this->url = (string)parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->isAJAX = array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Добавление пути в Router.
     *
     * @param string $name Название функции.
     * @param array $arguments Параметры передаваемые в неё. Пример: '/', [Controller::class, 'index'].
     * @option string $arguments[0] Путь.
     * @option string $arguments[1][0] Контроллер для запуска.
     * @option ?string $arguments[1][1] Вызываемый метод.
     * @return void
     * @throws RouterException
     */
    public static function __callStatic(string $name, array $arguments): void
    {
        $name = mb_strtoupper($name);

        if (!array_key_exists($name, self::$paths)) {
            throw new RouterException("Не существует такого HTTP метода: $name");
        }
        if (!is_array($arguments[1])) {
            throw new RouterException('Отсутствуют данные для запуска пути.');
        }
        if (!array_key_exists(0, $arguments[1])) {
            throw new RouterException('Отсутствует контроллер для запуска пути.');
        }
        if (!array_key_exists(1, $arguments[1])) {
            throw new RouterException('Отсутствует метод для запуска пути.');
        }

        $path = $arguments[0] ?: '/';
        $controller = $arguments[1][0];
        $method = $arguments[1][1];

        self::$paths[$name][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Инизиацизация запроса к роутеру.
     *
     * @throws RouterException
     * @throws ViewException
     */
    public function init(): string
    {
        if (!array_key_exists($this->url, self::$paths[$this->httpMethod])) {
            return $this->notFound();
        }

        return $this->router();
    }

    /**
     * Возвращает ошибку 404.
     *
     * @throws RouterException
     * @throws ViewException
     */
    private function notFound(): string
    {
        if ($this->isAJAX) {
            throw new RouterException('Такого пути не существует.');
        }

        header("HTTP/1.0 404 Not Found");
        $error = new ErrorController;
        $response = $error->index();

        return $this->basicStructure($error, $response);
    }

    /**
     * Возвращает базовую структуру сайта.
     *
     * @param AbstractController $controller Экземпляр контроллера.
     * @param string $response Содержимое страницы.
     * @return string
     * @throws ViewException
     */
    private function basicStructure(AbstractController $controller, string $response): string
    {
        $variables = $controller->init();
        return $variables['header'] . $response . $variables['footer'];
    }

    /**
     * Возвращает результат запроса.
     *
     * @throws RouterException
     */
    private function router(): string
    {
        try {
            $controller = new self::$paths[$this->httpMethod][$this->url]['controller'];
            $method = self::$paths[$this->httpMethod][$this->url]['method'];

            $response = $controller->$method(new Request);

            if (!$this->isAJAX) {
                $response = $this->basicStructure($controller, $response);
            }

            return $response;
        } catch (\Throwable $error) {
            throw new RouterException($error->getMessage(), $error->getCode());
        }
    }

}
