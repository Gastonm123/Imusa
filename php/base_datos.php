<?php

include_once 'base.php';
include_once 'usuario.php';
include_once 'usuarioInfo.php';

class Database {
    protected $conn;
    protected $servername = 'localhost';
    protected $username = 'poli_uno';
    protected $password = 'poli1';
    protected $db = 'poli_siete';
    public $error = False;
    
    public function __create() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);

        $instrucciones = [
            "CREATE TABLE users(
                id INT NOT NULL AUTO_INCREMENT, 
                username VARCHAR(20),
                password VARCHAR(40),
                email    VARCHAR(20),
                PRIMARY KEY (id),
                UNIQUE KEY (username),
                UNIQUE KEY (email)
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
            )"
        ];

        foreach ($instrucciones as $instruccion) {
            $result = $this->conn->query($instruccion);

            if ($result == FALSE) {
                var_dump($instruccion);
                $this->error = True;
            }
        }
    }

    public function actualizarUser ($usuario) {
        foreach ($usuario as $key => $value) {
            
        }

        $id = $usuario->id;
        $sql = 'UPDATE users SET () WHERE id = ';
    }

    public function actualizarUserInfo ($usuario) {

    }

    public function crearUser (Usuario $user) {
        // crear una entrada para users y una para users_info
        $sql = $this->insertString($user, 'users');
        $result = $this->conn->query($sql);

        if ($result == FALSE) {
            $this->error = True;
            echo 'Error creando el usuario';
            return;
        }

        $id = $this->lastId();
        $sql = "INSERT INTO users_info (uid) VALUES ($id)";
        $result = $this->conn->query($sql);

        if ($result == FALSE) {
            $this->error = True;
            echo 'Error creando la informacion del usuario';
            return;
        }
    }

    private function lastId() {
        $result = $this->conn->query('SELECT LAST_INSERT_ID()');
        $arr = $result->fetch_assoc();

        return $arr;
    }

    private function insertString (Base $object, $table) {
        $values = '';
        $keys = '';

        foreach ($object as $key => $value) {
            if (isempty($value)) {
                continue;
            }

            if ($key == 'password') {
                $values .= "SHA1('$values'),";
            } else {
                $values .= "'$values',";
            }

            $keys .= "$key,";
        }

        $values = rtrim($values, ',');
        $keys = rtrim($keys, ',');

        $sql = "INSERT INTO $table ($keys) VALUES ($values)";

        return $sql;
    }
}