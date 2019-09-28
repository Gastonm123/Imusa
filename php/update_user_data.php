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

$objeto = new Base($_POST);
$db = new Database();

$db->actualizarUser($objeto, $table);

if ($db->error) {
    die;
    $return['error'] = $db->error;
}

header('Content-Type: application/json');
echo json_encode($return);
