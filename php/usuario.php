<?php

include_once 'base.php';

class Usuario extends Base {
    public $username;
    public $password;
    public $email;

    public function init() {
        $sql = "CREATE TABLE IF NOT EXISTS users(
            id INT NOT NULL AUTO_INCREMENT, 
            username VARCHAR(20),
            password VARCHAR(40),
            email    VARCHAR(20),
            PRIMARY KEY (id),
            UNIQUE KEY (username),
            UNIQUE KEY (email)
        )";

        return $this->db->query($sql);
    }

    public function drop() {
        $sql = "DROP TABLE IF EXISTS users";

        return $this->db->query($sql);
    }

    public function vistaFormulario() {
        # obtener datos de user_info y mostrarlos incluyendo la plantilla
        $result = $this->db->obtenerUserInfo($this->id);

        // $name = $result['name'];
        // $surname = $result['surname'];
        // $birthdate = $result['birthdate'];
        // $nacionality = $result['nacionality'];
        // $description = $result['description'];

        include '../views/usuarioForm.php';
    }

    public function vistaArbol($offset) {
        $result = $this->db->obtenerUsers($offset);
						
        if (isset($result) && $this->db->error == FALSE) {
            $cont_column = 0;
            echo '<tr class="w3-green">';
            while ($field = $result->fetch_field()) {
                echo '<th>' . $field->name . '</th>';
                
                if ($field->name == 'rol') {
                    # seteo la variable en result por q al final lo devuelvo como
                    # informacion adicional de la vista
                    $result->rol_column = $cont_column;
                } 

                $cont_column++;
            }
            echo '</tr>';
            
            echo '<tbody>';
            for ($cont=0; $cont < 10; $cont++) { 
                $row = $result->fetch_row();

                if (isset($row)) {
                    echo '<tr class=\'account\'>';
                    
                    $cont_column = 0;
                    foreach ($row as $data) {
                        if ($cont_column == $result->rol_column) {
                            echo '
                            <td class="w3-dropdown-click w3-container permissions-dropdown">
                                <span>'.$data.'</span>
                                <div class="w3-dropdown-content w3-bar-block w3-border">
                                    <button class="w3-bar-item w3-button" onclick="setear('.$cont.', \'admin\')">admin</button>
                                    <button class="w3-bar-item w3-button" onclick="setear('.$cont.', \'user\')">user</button>
                                </div>
                            </td>
                            ';
                        } else {
                            echo '<td>' . $data . '</td>';
                        }

                        $cont_column++;
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