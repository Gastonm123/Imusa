<?php

include_once 'usuario.php';
include_once 'usuarioInfo.php';
include_once 'base.php';

$servername = 'localhost';
$username = 'poli_uno';
$password = 'poli1';
$db = 'poli_siete';

class Database {
    protected $conn;
    public $error = False;
    
    public function __construct() {
        $this->conn = new mysqli('localhost', 'poli_uno', 'poli1', 'poli_siete');

        $instrucciones = [
            "CREATE TABLE IF NOT EXISTS users(
                id INT NOT NULL AUTO_INCREMENT, 
                username VARCHAR(20),
                password VARCHAR(40),
                email    VARCHAR(20),
                PRIMARY KEY (id),
                UNIQUE KEY (username),
                UNIQUE KEY (email)
            )",
            "CREATE TABLE IF NOT EXISTS users_info(
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
                echo 'Error creando la base de datos';
                $this->error = True;
                return;
            }
        }
    }

    public function actualizarUser (Usuario $usuario) { // TODO hacer obligatorio los campos de usuario
        $sql = $this->updateString($usuario, 'users');
        
        $result = $this->conn->query($sql);

        return $result;
    }

    public function actualizarUserInfo (UsuarioInfo $usuario) {
        $sql = $this->updateString($usuario, 'users_info');

        $result = $this->conn->query($sql);

        return $result;
    }

    public function crearUser(Usuario $usuario) {
        // crear una entrada en la tabla users y otra en la tabla users_info
        $sql = $this->insertString($usuario, 'users');
        $result = $this->conn->query($sql);

        if ($result == FALSE) {
            echo 'Error creando un usuario';
            var_dump($sql);
            return FALSE;
        }

        $id = $this->lastId();
        $sql = "INSERT INTO users_info (uid) VALUES ($id)";
        $result = $this->conn->query($sql);

        if ($result == FALSE) {
            echo 'Error creando la informacion de usuario';
            $this->borrarUser($id);
            return FALSE;
        }

        return TRUE;
    }

    public function cerrar() {
        $this->conn->close();
    }

    public function borrarUser () {
        // PASS
    }

    private function lastId() {
        $result = $this->conn->query("SELECT LAST_INSERT_ID()");
        $arr = $result->fetch_assoc();

        return $arr['LAST_INSERT_ID()'];
    }

    private function updateString(Base $object, $table) {
        $fields = '';
        $values = '';

        foreach ($object as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $fields .= "$key,";
            $values .= "'$value',";
        }

        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');

        $id = $object->getId();
        $sql = "UPDATE $table ($fields) SET ($values) WHERE id = $id";

        return $sql;
    }

    private function insertString(Base $object, $table) {
        $fields = '';
        $values = '';

        foreach ($object as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if ($key == 'password') {
                $values .= "SHA1($value),";
            } else {
                $values .= "'$value',";
            }
            
            $fields .= "$key,";
        }

        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');

        $id = $object->getId();
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        return $sql;
    }
}