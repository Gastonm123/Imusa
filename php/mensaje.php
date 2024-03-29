<?php

include_once 'base.php';
include_once 'usuario.php';

class Mensaje extends Base {
    public $emisor;
    public $tipo;
    public $contenido;
    public $asunto;

    public function init() {
        $sql = "CREATE TABLE IF NOT EXISTS mensajes(
            id INT NOT NULL AUTO_INCREMENT,
            emisor VARCHAR(20) NOT NULL,
            tipo VARCHAR(20) NOT NULL,
            asunto TINYTEXT, 
            contenido TEXT,
            PRIMARY KEY (id)
        )"; 
            // destinatario VARCHAR(20) NOT NULL,
        // asunto es utilizado por el backend para especificar 
        // mensajes o solicitudes de adopcion

        return $this->db->query($sql);
    }

    public function drop() {
        $sql = "DROP TABLE IF EXISTS mensajes";

        return $this->db->query($sql);
    }

    public function vistaFormulario() {
        global $id;
        global $mensaje;
        global $username;

        $id = $this->id;
        $username = $_COOKIE['user'];
        $mensaje = $this->obtenerMensaje();

        if ($this->db->error != FALSE) {
            echo $this->db->error;
        } else {
            include '../views/mensajeForm.php';
        }
    }

    public function obtenerMensaje() {
        if (empty($this->id)) {
            return [];
        }

        $mensaje = $this->db->obtener_objeto('mensajes', ['tipo', 'emisor', 'asunto', 'contenido'], ['id' => $this->id]);

        if ($mensaje->num_rows > 1 || $this->db->error != False) {
            $this->db->error = "Error obteniendo mensaje";
        }

        return $mensaje->fetch_assoc();
    }

    public function vistaArbol() {
        // obtener mensajes y mostrarlos
        $mensajes = $this->db->obtener_objeto('mensajes', ['id', 'emisor', 'tipo', 'asunto'], []);

        if (isset($mensajes) && $this->db->error == FALSE) {
            $cont_column = 0;
            echo '<thead class="w3-green">';
            while ($field = $mensajes->fetch_field()) {
                echo '<td>' . $field->name . '</td>';

                $cont_column++;
            }
            echo '</thead>';

            echo '<tbody>';
            for ($cont = 0; $cont < 10; $cont++) {
                $row = $mensajes->fetch_row();

                if (isset($row)) {
                    $id = $row[0];
                    echo "<tr class='account' id='$id'>";

                    foreach ($row as $data) {
                        echo '<td>' . $data . '</td>';
                    }

                    echo '</tr>';
                } else {
                    echo "<tr><td colspan='$mensajes->field_count'><br></td></tr>";
                }
            }
            echo '</tbody>';
        } else {
            echo 'No se han podido cargar los datos';
        }

        return $mensajes;
    }
}