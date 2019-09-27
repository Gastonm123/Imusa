<?php

trait sql_base {
    private function updateString(Base $object, $table) {
        $fields = '';

        foreach ($object as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $fields .= "$key='$value',";
        }

        $fields = rtrim($fields, ',');

        $id = $object->getId();
        $sql = "UPDATE $table SET $fields";

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

        $id = $object->getId();
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        return $sql;
    }
}