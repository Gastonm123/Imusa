<?php

include 'datos.php';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
	echo "Error ingresando a la base de datos";
	die;
}


$sql = "CREATE TABLE users(
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

$sql = "CREATE TABLE users_info(
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

$sql = "INSERT INTO users 
	(username, password, email) VALUES 
	('admin', SHA1('admin'), 'admin') ";

if ($conn->query($sql) !== FALSE) {
	echo "Usuario admin creado con exito";
} else {
	echo "Error creando el usuario admin";
	die;
}

$sql = "SELECT LAST_INSERT_ID()";

if ($result = $conn->query($sql)) {
	$id_admin = $result->fetch_row()[0];
} else {
	echo 'Error obteniendo el id del usuario admin';
	die;
}

$sql = 'INSERT INTO users_info (uid) VALUES (\'' . $id_admin . '\')';

if ($conn->query($sql)) {
	echo 'Info del usuario admin creada';
} else {
	echo 'Error creando info del usuario admin';
	die;
}

$sql = 'CREATE TABLE permissions (
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

$sql = 'INSERT INTO permissions (uid, rol) VALUES (\'' . $id_admin . '\', \'admin\')';

if ($conn->query($sql)) {
	echo 'Rol creado con exito para admin';
} else {
	echo 'Error creando un rol para admin';
	die;
}
