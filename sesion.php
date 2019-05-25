<?php

/* establecer la conexion y checkear que se haya enviado un formulario */
if(!$_POST) {
	die("Error, ningun formulario fue enviado");
}

$con = new mysqli("localhost", "gaston", "", "imusa");

if($con->error) {
	die ("Conexion abortada\n");
}


$USER = $_POST['user'];
$PASS = $_POST['pass'];

$query = "SELECT * FROM usuarios WHERE username=$USER AND password=SHA1($PASS)";

$ans = $con->query($query);

if($con->error){
    die($con->error);
}

if($ans->num_rows){
    #setear usuario en el servidor
    #redirigir
    die('Sesion Iniciada');
} else {
    die('Password o usuario incorrectas');
}

?>