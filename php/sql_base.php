<?php

trait sql_base {
    private function updateString(Base $object, $table, $restricciones) {
        $fields = '';

        foreach ($object as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $fields .= "$key='$value',";
        }

        $fields = rtrim($fields, ',');

        $where = $this->whereString($restricciones);
        $sql = "UPDATE $table SET $fields WHERE $where";

        return $sql;
    }

    private function whereString($fields) {
        $string = '';

        foreach ($fields as $key => $value) {
            // TODO poner hash al value si la key es password
            if ($key == 'password') {
                $string .= "$key=SHA1('$value') AND ";
            } else {
                $string .= "$key='$value' AND ";
            }
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

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        return $sql;
    }

    private function selectString(Base $object, $table, $restricciones) {
        $keys = "";

        foreach ($object as $key => $value) {
            if (empty($value)) {
                continue;
            }
            
            $keys .= "$key,";
        }

        $keys = rtrim($keys, ',');
        $where = $this->whereString($restricciones);

        $sql = "SELECT $keys FROM $table WHERE $where";

        return $sql;
    }

    private function deleteString($table, $restricciones) {
        $where = $this->whereString($restricciones);
        $sql = "DELETE FROM $table WHERE $where";

        return $sql;
    }
}