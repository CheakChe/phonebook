<?php

namespace App\Core;

use PDO;
use PDOException;

class Model
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(env('DNS'), env('DB_USER'), env('DB_PASS'));
        } catch (PDOException $error) {
            die(Log::writeLog("Подключение не удалось: {$error->getMessage()}"));
        } catch (\Throwable $error){
            die(Log::writeLog("Неожиданная ошибка: {$error->getMessage()}"));
        }
    }

    protected function fetch_all($query): array
    {
        try {
            $fetch_assoc = $this->db->query($query);
        } catch (PDOException $e) {
            die(Log::writeLog('Ошибка: ' . $e->getMessage()));
        }
        return $fetch_assoc->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetch_assoc($query)
    {
        try {
            $fetch_assoc = $this->db->query($query);
        } catch (PDOException $e) {
            die(Log::writeLog('Ошибка: ' . $e->getMessage()));
        }
        return $fetch_assoc->fetch(PDO::FETCH_ASSOC);
    }

    protected function query($query): void
    {
        try {
            $this->db->exec($query);
        } catch (PDOException $e) {
            die(Log::writeLog('Ошибка: ' . $e->getMessage()));
        }
    }

}