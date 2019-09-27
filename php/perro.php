<?php

include_once 'base.php';

class Perro extends Base {
    public $jaula;
    public $sexo;
    public $raza;
    public $adoptabilidad;
    public $edad;
    public $observaciones;

    function init() {
        $sql = "CREATE TABLE IF NOT EXISTS perros (
            id INT AUTO_INCREMENT NOT NULL,
            jaula VARCHAR(10),
            sexo VARCHAR(10),
            raza VARCHAR(20),
            adoptabilidad VARCHAR(20),
            edad VARCHAR(20),
            observaciones TEXT,
            PRIMARY KEY (id)
        )";

        return $this->db->query($sql);
    }

    public function drop() {
        $sql = "DROP TABLE IF EXISTS perros";

        return $this->db->query($sql);
    }

    public function vistaFormulario() {
        # crear vista
    }

    public function vistaArbol($offset) {
        $result = $this->db->obtenerPerros($offset);
						
        if (isset($result) && $this->db->error == FALSE) {
            $cont_column = 0;
            echo '<tr class="w3-green">';
            while ($field = $result->fetch_field()) {
                echo '<th>' . $field->name . '</th>';

                $cont_column++;
            }
            echo '</tr>';
            
            echo '<tbody>';
            for ($cont=0; $cont < 10; $cont++) { 
                $row = $result->fetch_row();

                if (isset($row)) {
                    echo '<tr class=\'account\'>';
                
                    foreach ($row as $data) {
                        echo '<td>' . $data . '</td>';
                    }
                    
                    echo '</tr>';
                } else {
                    echo "<tr><td colspan='$result->field_count'><br></td></tr>";
                }
            }
            echo '</tbody>';
        } else {
            echo 'No se han podido cargar los datos';
        }

        return $result;
    }
}