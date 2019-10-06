<?php

include_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = $_POST;
} else {
    $data = $_GET;
}

$db = new Database();
$response = [];

if ($data['comando'] == 'select') {
    $result = $db->obtener_objeto($data['tabla'], $data['campos'], $data['restricciones']);

    if ($db->error) {
        $response['error'] = $db->error;
    } else {
        $response['value'] = $result;
    }
}

if ($data['comando'] == 'create') {
    $result = $db->crear_objeto($data['tabla'], $data['values']);

    if ($db->error) {
        $response['error'] = $db->error;
    } else {
        $id = $db->lastId();
        
        if ($db->error) {
            $response['error'] = $db->error;
        } else {
            $response['value'] = $id;
        }
    }
}

if ($data['comando'] == 'update') {
    $result = $db->actualizar_objeto($data['tabla'], $data['values'], $data['restricciones']);

    if ($db->error) {
        $response['error'] = $db->error;
    } else {
        $response['value'] = true;
    }
}

if ($data['comando'] == 'delete') {
    $result = $db->eliminar_objeto($data['tabla'], $data['restricciones']);

    if ($db->error) {
        $response['error'] = $db->error;
    } else {
        $response['value'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$db->cerrar();