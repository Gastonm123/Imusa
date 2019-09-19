<?php

include ''
$servername = 'localhost';
$username = 'poli_uno';
$password = 'poli1';
$db = 'poli_siete';

class Database {
    protected $conn;
    
    public function __create() {
        $this->conn = new mysqli($servername, $username, $password, $db);

        $instrucciones = [
            "CREATE TABLE users(
                id INT NOT NULL AUTO_INCREMENT, 
                username VARCHAR(20),
                password VARCHAR(40),
                email    VARCHAR(20),
                PRIMARY KEY (id),
                UNIQUE KEY (username, email)
            )",
            "CREATE TABLE users_info(
                uid INT NOT NULL,
                name VARCHAR(20),
                surname VARCHAR(20),
                birthdate DATE,
                nacionality VARCHAR(20),
                description TINYTEXT,
                rol VARCHAR(20) DEFAULT 'user',
                PRIMARY KEY (uid),
                UNIQUE KEY (uid)
            )",
            "INSERT INTO users 
                (username, password, email) VALUES 
                ('admin', SHA1('admin'), 'admin'
            )",
            'INSERT INTO users_info (uid) VALUES ("1")'
        ];

        foreach ($instrucciones as $instruccion) {
            $result = $this->conn->query($instruccion);

            if ($result == FALSE) {
                throw new Error('No se pudo inicializar la base de datos correctamente');
            }
        }
    }

    public function actualizarUser ($usuario) {
        foreach ($usuario as $key => $value) {
            
        }

        $id = $usuario->id;
        $sql = 'UPDATE users SET () WHERE id = '
    }

    public function actualizarUserInfo ($usuario) {

    }
}