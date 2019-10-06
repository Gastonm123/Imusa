<?php

include_once 'usuario.php';
include_once 'usuarioInfo.php';
include_once 'base.php';
include_once 'sql_base.php';
include_once 'perro.php';
include_once 'mensaje.php';

class Database {
    protected $conn;
    protected $objetos;
    public $error = False;
    use sql_base;
    
    public function __construct() {
        $this->conn = new mysqli('localhost', 'poli_uno', 'poli1', 'poli_siete');
        $this->objetos = [
            new Usuario(['db' => $this]),
            new UsuarioInfo(['db' => $this]),
            new Perro(['db' => $this]),
            new Mensaje(['db' => $this])
        ];

        foreach ($this->objetos as $objeto) {
            if ($objeto->init() == FALSE) {
                $this->error = 'Error inicializando la tabla ' . get_class($objeto);
                break;
            }
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function drop() {
        foreach ($this->objetos as $objeto) {
            if ($objeto->drop() == FALSE) {
                $this->error = "Error eliminando la tabla " . get_class($objeto);
                break;
            }
        }
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

        return $result;
    }

    public function obtenerPerros($offset) {
        $sql = 'SELECT * FROM perros 
            ORDER BY id LIMIT '.$offset.', '.($offset+10);
        
        $result = $this->query($sql);
        
        if ($result == FALSE) {
            $this->error = 'Error obteniendo los perros';
            return;
        }

        return $result;
    }

    public function getUser($fields) {
        $where = $this->whereString($fields);
        $sql = "SELECT id, username, email 
            FROM users WHERE $where";

        $result = $this->conn->query($sql);

        if ($result == FALSE || $result->num_rows != 1) {
            $this->error = "Error accediendo al usuario";
            return;
        }

        return $result->fetch_assoc();
    }

    public function cerrar() {
        $this->conn->close();
    }

    public function borrarUser ($id) {
        $sql = "DELETE FROM users WHERE id=$id";

        return $this->conn->query($sql);
    }

    public function lastId() {
        $result = $this->conn->query("SELECT LAST_INSERT_ID()");
        $arr = $result->fetch_assoc();

        return $arr['LAST_INSERT_ID()'];
    }

    public function obtener_objeto($tabla, $campos, $restricciones) {
        $arr = [];
        foreach ($campos as $campo) {
            $arr[$campo] = 10;
        }

        $objeto = new Base($arr);

        $sql = $this->selectString($objeto, $tabla, $restricciones);
        $result = $this->query($sql);

        if ($result == false) {
            $this->error = "Error obteniendo informacion de la tabla $tabla";
        }

        return $result;
    }

    public function crear_objeto($tabla, $valores) {
        $arr = [];
        foreach ($valores as $key=>$value) {
            $arr[$key] = $value;
        }

        $objeto = new Base($arr);

        $sql = $this->insertString($objeto, $tabla);
        $result = $this->query($sql);

        if ($result == false) {
            $this->error = "Error creando un objeto en la tabla $tabla";
        }

        return $result;
    }

    public function actualizar_objeto($tabla, $valores, $restricciones) {
        $arr = [];
        foreach ($valores as $key=>$value) {
            $arr[$key] = $value;
        }

        $objeto = new Base($arr);

        $sql = $this->updateString($objeto, $tabla, $restricciones);
        $result = $this->query($sql);

        if ($result == false) {
            $this->error = "Error creando un objeto en la tabla $tabla";
        }

        return $result;
    }

    public function eliminar_objeto($tabla, $restricciones) {
        $sql = $this->deleteString($tabla, $restricciones);
        $result = $this->query($sql);

        if ($result == false) {
            $this->error = "Error eliminando objeto de la tabla $tabla";
        }

        return $result;
    }
}