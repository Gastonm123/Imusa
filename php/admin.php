<?php

include_once 'database.php';
include_once 'usuario.php';
include_once 'usuarioInfo.php';

$db = new Database;

// crear usuario admin con username admin y password admin
$admin = new Usuario(['username'=>'admin', 'password'=>'admin']);

$db->crearUser($admin);


$adminInfo = new UsuarioInfo(["rol"=>"admin", "id" => 1]);

$db->actualizarUserInfo($adminInfo);

if ($db->error) {
    echo $db->error;
} else{
    echo '<h1>Funciono</h1>';
}

$db->cerrar();