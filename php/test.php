<?php

include 'datos.php';

$conn = new mysqli($servername, $username, $password, $db);

$sql = 'SELECT * FROM users';

if ($result = $conn->query($sql)) {
    var_dump($result->fetch_row());
} else {
    echo 'xd';
    die;
}
