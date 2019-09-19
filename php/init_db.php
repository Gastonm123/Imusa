<?php

include 'conexion.php';

if ($conn->connect_error) {
	echo "Error ingresando a la base de datos";
	die;
}


$sql = "CREATE TABLE IF NOT EXISTS users(
	id INT NOT NULL AUTO_INCREMENT, 
	username VARCHAR(20),
	password VARCHAR(40),
	email    VARCHAR(20),
	PRIMARY KEY (id),
	UNIQUE KEY (username, email)
)";

if ($conn->query($sql) !== FALSE) {
	echo "Tabla users creada con exito";
} else {
	echo "Error creando la tabla users";
	die;
}

$sql = "CREATE TABLE IF NOT EXISTS users_info(
	uid INT NOT NULL,
	name VARCHAR(20),
	surname VARCHAR(20),
	birthdate DATE,
	nacionality VARCHAR(20),
	description TINYTEXT,
	PRIMARY KEY (uid),
	UNIQUE KEY (uid)
)";

if ($conn->query($sql) !== FALSE) {
	echo "Tabla users_info creada con exito";
} else {
	echo "Error creando la tabla users";
	die;
}

$sql = 'CREATE TABLE IF NOT EXISTS permissions (
	uid INT NOT NULL,
	rol VARCHAR(20) NOT NULL,
	PRIMARY KEY (uid),
	UNIQUE KEY (uid)
)';

if ($conn->query($sql)) {
	echo 'Tabla permissions creada con exito';
} else {
	echo 'Error creando la tabla permissions';
	die;
}
