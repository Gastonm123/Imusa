<?php

include_once 'base.php';

class UsuarioInfo extends Base {
    public $name;
    public $surname;
    public $birthdate;
    public $nacionality;
    public $description;
    public $rol;

    public function init($conn) {
        $sql = "CREATE TABLE IF NOT EXISTS users_info(
            uid INT NOT NULL,
            name VARCHAR(20),
            surname VARCHAR(20),
            birthdate DATE,
            nacionality VARCHAR(20),
            description TINYTEXT,
            rol VARCHAR(20) DEFAULT 'user',
            PRIMARY KEY (uid),
            UNIQUE KEY (uid)
        )";

        $result = $conn->query($sql);

        return $result;
    }
}