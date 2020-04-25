<?php

    namespace App\Models;

    use App\Core\Model;

    class PhoneModel extends Model
    {
        public function allPhone(): array
        {
            return $this->fetch_all('SELECT * FROM `phonebook`');
        }

        public function uniquePhone($phone)
        {
            $result = $this->fetch_assoc("SELECT `phone-number` FROM `phonebook` WHERE `phone-number`='$phone'");
            $result = empty($result) ?: false;
            return $result;
        }

        public function updatePhone(): void
        {
            $this->query("UPDATE `phonebook` SET `second-name`='{$_POST['second-name']}', `phone-number`='{$_POST['phone-number']}' WHERE `id`='{$_POST['id']}'");
        }

        public function deletePhone(): void
        {
            $this->query("DELETE FROM `phonebook` WHERE `id`='{$_POST['id']}'");
        }
    }