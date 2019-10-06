<?php

include_once 'base.php';

class Perro extends Base
{
    public $jaula;
    public $sexo;
    public $raza;
    public $adoptabilidad;
    public $edad;
    public $observaciones;

    function init()
    {
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

    public function drop()
    {
        $sql = "DROP TABLE IF EXISTS perros";

        return $this->db->query($sql);
    }

    public function vistaFormulario()
    {
        # crear vista
        $jaula = 'ejemplo';
        $sexo = 'ejemplo';
        $raza = 'ejemplo';
        $adoptabilidad = 'ejemplo';
        $edad = 0;
        $observaciones = 'ejemplo';

        include '../views/perroForm.php';
    }

    public function vistaArbol($offset)
    {
        $result = $this->db->obtenerPerros($offset);

        if (isset($result) && $this->db->error == FALSE) {
            $cont_column = 0;
            echo '<thead class="w3-green">';
            while ($field = $result->fetch_field()) {
                echo '<td>' . $field->name . '</td>';

                $cont_column++;
            }
            echo '</thead>';

            echo '<tbody>';
            for ($cont = 0; $cont < 10; $cont++) {
                $row = $result->fetch_row();

                if (isset($row)) {
                    $id = $row[0];
                    echo "<tr class='account' id='$id'>";

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
