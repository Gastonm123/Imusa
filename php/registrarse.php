<?php

include('datos.php');

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
	die("Connection error");
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
			die('Email malformado');
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
	var_dump($response);
	echo '\n';
	die($sql);
} else {
	echo 'Data ingresada con exito a users';
}

$sql = 'SELECT LAST_INSERT_ID()';

if ($result = $conn->query($sql)) {
	$user_id = $result->fetch_row()[0];
} else {
	echo 'Error ingresando a la tabla users_info';
	die;
}

$sql = 'INSERT INTO users_info (uid) VALUES (\'' . $user_id . '\')';

if ($conn->query($sql)) {
	echo 'Data ingresada con exito a users_info';
} else {
	echo 'Error ingresando a la tabla users_info';
	die;
}

$sql = 'INSERT INTO permissions (uid, rol) VALUES (\'' . $user_id . '\', \'user\')';

if ($conn->query($sql)) {
	echo 'Rol configurado con exito';
} else {
	echo 'Error creando rol para el usuario';
	die;
}

$conn->close();
