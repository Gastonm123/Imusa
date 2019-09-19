<?php

include 'database.php';
include 'usuario.php';

$db = new Database;

// crear usuario admin con username admin y password admin
$admin = new Usuario(['username'=>'admin', 'password'=>'admin']);

$db->crearUser($admin);

$db->cerrar();