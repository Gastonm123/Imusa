<?php

include 'datos.php';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    echo 'esto no anda';
    var_dump($servername);
    var_dump($username);
    var_dump($password);
    var_dump($db);
    die;
} else {
    echo 'esto si anda';
}

var_dump($conn);
$response = $conn->query("SELECT * FROM users");

echo ($response === FALSE);
