<?php

include_once 'usuario.php';
include_once 'usuarioInfo.php';
include_once 'base.php';

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
                $this->error = 'Error creando la base de datos';
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
            $this->error = "Error creando un usuario";
            return FALSE;
        }

        $id = $this->lastId();
        $sql = "INSERT INTO users_info (uid) VALUES ($id)";
        $result = $this->conn->query($sql);

        if ($result == FALSE) {
            $this->error = "Error creando la informacion del usuario";
            $this->borrarUser($id);
            return FALSE;
        }

        return TRUE;
    }

    public function obtenerUsers($offset) {
        $sql = 'SELECT id, username, email, rol FROM users 
            INNER JOIN users_info ON users.id = users_info.uid
            ORDER BY id LIMIT '.$offset.', '.($offset+10);
        
        $result = $this->conn->query($sql);
        
        if ($result == FALSE) {
            $this->error = 'Error obteniendo los usuarios';
            return;
        }

        return $result->fetch_array();
    }


    public function getUserInfo($id) {
        $sql = "SELECT name, surname, birthdate, nacionality, description, rol 
            FROM users_info WHERE id = $id";

        $result = $this->conn->query($sql);

        if ($result == FALSE || $result->num_rows != 1) {
            $this->error = "Error accediendo a la informacion del usuario";
            return;
        }

        return $result->fetch_assoc();
    }

    public function getUser($fields) {
        $where = $this->whereString($fields);
        $sql = "SELECT id, username, email 
            FROM users WHERE $where";

        $result = $this->conn->query($sql);

        if ($result == FALSE || $result->num_rows != 1) {
            var_dump($result->fetch_assoc);
            $this->error = "Error accediendo al usuario";
            return;
        }

        return $result->fetch_assoc();
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

    private function whereString($fields) {
        $string = '';

        foreach ($fields as $key => $value) {
            // TODO poner hash al value si la key es password
            $string .= "$key='$value' AND ";
        }

        $string = rtrim($string, ' AND');

        return $string;
    }

    private function insertString(Base $object, $table) {
        $fields = '';
        $values = '';

        foreach ($object as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if ($key == 'password') {
                $values .= "SHA1('$value'),";
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