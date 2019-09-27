<?php

include_once 'base.php';

class Usuario extends Base {
    public $username;
    public $password;
    public $email;

    public function init($conn) {
        $sql = "CREATE TABLE IF NOT EXISTS users(
            id INT NOT NULL AUTO_INCREMENT, 
            username VARCHAR(20),
            password VARCHAR(40),
            email    VARCHAR(20),
            PRIMARY KEY (id),
            UNIQUE KEY (username),
            UNIQUE KEY (email)
        )";

        $result = $conn->query($sql);

        return $result;
    }
}