<?php

namespace App\Models;

use App\Core\Model;

class PhoneModel extends Model
{
    public function allPhone(): array
    {
        return $this->fetch_all('SELECT * FROM `phonebook`');
    }

    public function uniquePhone()
    {
        $result = $this->fetch_assoc("SELECT `phone-number` FROM `phonebook` WHERE `phone-number`='{$_POST['phone-number']}'");
        $result = empty($result) ?: false;
        return $result;
    }

    public function updatePhone(): void
    {
        $this->query("UPDATE `phonebook` SET `second-name`='{$_POST['second-name']}', `phone-number`='{$_POST['phone-number']}' WHERE `id`='{$_POST['id']}'");
    }

    public function anotherName()
    {
        $result = $this->fetch_assoc("SELECT `second-name` FROM `phonebook` WHERE `second-name`='{$_POST['second-name']}' AND `id`='{$_POST['id']}'");
        $result = empty($result) ?: false;
        return $result;
    }

    public function deletePhone(): void
    {
        $this->query("DELETE FROM `phonebook` WHERE `id`='{$_POST['id']}'");
    }

    public function addPhone()
    {
        $this->query("INSERT INTO `phonebook` SET `second-name`='{$_POST['second-name']}', `phone-number`='{$_POST['phone-number']}'");
        return $this->fetch_assoc("SELECT * FROM `phonebook` WHERE `id`='{$this->db->lastInsertId()}'");
    }
}