<?php

include 'datos.php';

if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die;
}

$conn = new mysqli($servername, $username, $password, $db);

if (empty($_POST['uid']) || empty($_POST['table'])) {
    echo 'Informacion provista insuficiente';
    die;
}

$user_id = $_POST['uid'];
$table = $_POST['table'];

unset($_POST['uid']);
unset($_POST['table']);

$assignment_list = '';
foreach ($_POST as $key => $value) {

    if (!empty($value)) {
        $assignment_list .= $key . '=\'' . $value . '\',';
    }
}

$assignment_list = rtrim($assignment_list, ',');

if (empty($assignment_list)) {
    echo 'Informacion actualizada con exito';    
    die;
}


$sql = 'UPDATE '.$table.' SET ' . $assignment_list . ' WHERE uid=' . $user_id;

if ($conn->query($sql)) {
    echo 'Informacion actualizada con exito';
} else {
    echo 'Error actualizando la informacion de usuario';
    die;
}
