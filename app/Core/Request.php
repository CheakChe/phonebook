<?php


namespace App\Core;

class Request
{
    private array $request;

    public function __construct()
    {
        $this->request = json_decode(file_get_contents('php://input'), true) ?: $_REQUEST;
    }

    /**
     * Возвращает параметр запроса по ключу.
     *
     * @param string $key Ключ.
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->request[$key];
    }

    /**
     * Возвращает все параметры запроса.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->request;
    }

}