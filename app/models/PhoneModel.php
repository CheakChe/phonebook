<?php

    class PhoneModel extends Model
    {
        public function allPhone(): array
        {
            return $this->fetch_all('SELECT * FROM `phonebook`');
        }
    }