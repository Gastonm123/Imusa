<?php

include('datos.php');

function flash($mensaje) {
	setcookie("flash", $mensaje, time()+60, "/");
	die;
}

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
	flash("Error del servidor");
}

$keys = '';
$values = '';
foreach ($_POST as $key => $value) {
	if ($key == 'descripcion') {
		continue;
	}

	$keys .= $key . ',';

	if ($key == 'email') {
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			flash("Email malformado");
		}
	}

	if ($key == 'password') {
		$values .= 'SHA1(\'' . $value . '\'),';
	} else {
		$values .= '\'' . $value . '\',';
	}
}

$keys = rtrim($keys, ',');
$values = rtrim($values, ',');

$sql = 'INSERT INTO users (' . $keys . ') VALUES (' . $values . ')';
$response = $conn->query($sql);
if ($response !== TRUE) {
	flash("El usuario que se intenta crear ya existe");
} else {
	echo 'Data ingresada con exito a users';
}

$sql = 'SELECT LAST_INSERT_ID()';

if ($result = $conn->query($sql)) {
	$user_id = $result->fetch_row()[0];
} else {
	flash("Error creando informacion del usuario. Por favor avise de este error");
}

$sql = 'INSERT INTO users_info (uid) VALUES (\'' . $user_id . '\')';

if ($conn->query($sql)) {
	echo 'Data ingresada con exito a users_info';
} else {
	flash("Error creando informacion del usuario. Por favor avise de este error");	
}

$sql = 'INSERT INTO permissions (uid, rol) VALUES (\'' . $user_id . '\', \'user\')';

if ($conn->query($sql)) {
	echo 'Rol configurado con exito';
} else {
	flash("Error creando informacion del usuario. Por favor avise de este error");	
}

flash("Usuario creado con exito");
$conn->close();
