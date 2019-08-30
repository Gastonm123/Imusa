<?php

include 'datos.php';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) { 
    echo 'Error accediendo a la base de datos';
    die;
}

$sql = 'DROP TABLE users';

if ($conn->query($sql)) {
    echo 'Tabla users eliminada';
} else {
    echo 'Error eliminando la tabla users';
}

$sql = 'DROP TABLE users_info';

if ($conn->query($sql)) {
    echo 'Tabla users_info eliminada';
} else {
    echo 'Error eliminando la tabla users_info';
}

$sql = 'DROP TABLE permissions';

if ($conn->query($sql)) {
    echo 'Tabla permissions eliminada';
} else {
    echo 'Error eliminando la tabla permissions';
}