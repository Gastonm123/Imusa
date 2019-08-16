<?php

include 'datos.php';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
	echo "Error ingresando a la base de datos";
	die;
}


$sql = "CREATE TABLE users(
	username VARCHAR(20),
	password VARCHAR(40),
	email    VARCHAR(20)
)";

if ($conn->query($sql) !== FALSE) {
	echo "Tabla creada con exito";
} else {
	echo "Error creando la tabla";
	die;
}

$sql = "INSERT INTO users 
	(username, password, email) VALUES 
	('admin', SHA1('admin'), 'admin') ";

if ($conn->query($sql) !== FALSE) {
	echo "Usuario admin creado con exito";
} else {
	echo "Error creando el usuario admin";
	die;
}

