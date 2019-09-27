<?php

include_once 'database.php';

$db = new Database();

$db->drop();

if ($db->error) {
    echo $db->error;
} else {
    echo 'Exito';
}