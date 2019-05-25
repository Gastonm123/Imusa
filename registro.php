<?php

/* establecer la conexion y checkear que se haya enviado un formulario */
if(!$_POST) {
	echo "Error, ningun formulario";
	exit();
}

$con = new mysqli("localhost", "gaston", "1234", "imusa");

if($con->error) {
	echo "Error de conexion";
	exit();
}



/* checkear si el mail y/o el usuario estan pickeados */
$MAIL = $_POST["mail"];
$USER = $_POST["username"];

$query = $con->query("SELECT email, username FROM usuarios WHERE email='$MAIL' AND username='$USER'");

if($con->error) {
	echo "Error de conexion";
	exit();
}

if($query->num_rows) {
	#redirigir
	echo "Usuario ya pickeado";
	exit();
}



/* registrar al usuario */
$PASSWORD = $_POST["password"];
$NOMBRE = $_POST["nombre"];
$APELLIDO = $_POST["apellido"];
$DNI = $_POST["dni"];
$NACIMIENTO = $_POST["nacimiento"];
$NACIONALIDAD = $_POST["nacionalidad"];

$query = "INSERT INTO usuarios (email, username, password, name, surname, dni, birthday, nationality)
		VALUES ('$MAIL', '$USER', SHA1('$PASSWORD'), '$NOMBRE', '$APELLIDO', '$DNI', '$NACIMIENTO', '$NACIONALIDAD')";

$con->query($query);

if($con->error) {
	echo "Error de conexion";
	exit();
}

echo "Usuario registrado";



/* ingresar la descripcion, si existe */
$DESCRIPCION = $_POST["descripcion"];

if($DESCRIPCION){
	$con->query("UPDATE usuarios SET description=$DESCRIPCION WHERE username='$USER'");

	if($con->error){
		echo "Error de conexion";
		exit();
	}
}
#redirigir

?>
