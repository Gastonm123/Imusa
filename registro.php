<?php

/* establecer la conexion y checkear que se haya enviado un formulario */

if(!$_POST) {
	echo "Error, ningun formulario";
	exit;
}

mysqli_report(MYSQLI_REPORT_STRICT);

try {
    $con = new mysqli("localhost", "gaston", "1234", "imusa");
} catch (Exception $e) {
	echo 'Error de conexion';
    exit;
}


/* checkear si el mail y/o el usuario estan pickeados */
$MAIL = $_POST["mail"];
$USER = $_POST["username"];

$query = $con->query("SELECT email, username FROM usuarios WHERE email='$MAIL' AND username='$USER'");

if(!$query) {
	echo "Error en la query";
	exit;
}

if($query->num_rows) {
	echo "Usuario ya pickeado";
	exit;
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

if(!$con->query($query)) {
	echo "Error en la query";
	exit;
}

echo "Usuario registrado";



/* ingresar la descripcion, si existe */
$DESCRIPCION = $_POST["descripcion"];

if($DESCRIPCION){
	$query = "UPDATE usuarios SET description=$DESCRIPCION WHERE username='$USER'";

	if(!$con->query($query)) {
		echo "Error en la query";
		exit;
	}
}

$con->close()

?>
