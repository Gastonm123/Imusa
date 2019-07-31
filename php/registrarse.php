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
if ($conn->query($sql) !== TRUE) {
	die('Error en la data provista');
}

echo 'Data ingresada con exito';
$conn->close();
