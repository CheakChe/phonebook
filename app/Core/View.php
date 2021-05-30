<?php


namespace App\Core;


use App\Exceptions\ViewException;

class View
{
    private const PATH = './app/template/';

    /**
     * Формирует шаблон.
     *
     * @param string $template Путь к шаблону.
     * @param array|null $properties Свойства необходимые в шаблоне.
     * @return bool|string
     * @throws ViewException
     */
    public function render(string $template, array|null $properties = NULL): bool|string
    {
        if (!file_exists(self::PATH . "$template.php")) {
            throw new ViewException('not template');
        }

        if (!empty($properties)) {
            $this->setterArray($properties);
        }

        ob_start();
        include self::PATH . "$template.php";
        return ob_get_clean();
    }

    /**
     * Добавляет массив свойств в шаблон.
     *
     * @param array $array Свойства.
     */
    private function setterArray(array $array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

}
