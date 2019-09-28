<?php

include_once 'database.php';
include_once 'base.php';

if (empty($_POST['uid']) || empty($_POST['table'])) {
    echo 'Informacion provista insuficiente';
    die;
}

$uid = $_POST['uid'];
$table = $_POST['table'];
$return = [];

unset($_POST['uid']);
unset($_POST['table']);

if ($table == 'users_info') {
    $objeto = new UsuarioInfo($_POST);
} else {
    $objeto = new Base($_POST);
}

$objeto->setId($uid);
$db = new Database();

$db->actualizarUser($objeto, $table);

if ($db->error) {
    echo $db->error;
}

$db->cerrar();