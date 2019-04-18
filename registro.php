<?php

/* establecer la conexion y checkear que se haya enviado un formulario */
if(!$_POST) {
	die("Error, ningun formulario fue enviado");
}

$con = new mysqli("localhost", "gaston", "1234", "imusa");

if($con->error) {
	die ("Conexion abortada\n");
}



/* checkear si el mail y/o el usuario estan pickeados */
$MAIL = $_POST["mail"];
$USER = $_POST["username"];

$query = $con->query("SELECT email, username FROM usuarios WHERE email='$MAIL' AND username='$USER'");

if($con->error) {
	die($con->error);
}

if($query->num_rows) {
	die("Username or email already picked");
}



/* registrar al usuario */
$PASSWORD = $_POST["password"];
$NOMBRE = $_POST["nombre"];
$APELLIDO = $_POST["apellido"];
$DNI = $_POST["dni"];
$NACIMIENTO = $_POST["nacimiento"];
$NACIONALIDAD = $_POST["nacionalidad"];

$query = "INSERT INTO usuarios (email, username, password, name, surname, dni, birthday, nationality)
		VALUES ('$MAIL', '$USER', $PASSWORD, $NOMBRE, $APELLIDO, $DNI, $NACIMIENTO, $NACIONALIDAD)";

$con->query($query) or die($con->error);

echo "\nUser registered\n";



/* ingresar la descripcion, si existe */
$DESCRIPCION = $_POST["descripcion"];

if($DESCRIPCION){
	$con->query("UPDATE usuarios SET description=$DESCRIPCION WHERE username='$USER'") 
		or die($con->error);
}

die("\nRegistro finalizado\n");

?>
