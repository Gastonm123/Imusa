<?php

include('datos.php');

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
	die($conn->connect_error);
}

echo "Connected successfully\n";

$sql = "CREATE DATABASE " . $db;
if ($conn->query($sql) !== TRUE) {
	echo ("Unable to create the database\n");
}

$sql = "USE " . $db;
if ($conn->query($sql) !== TRUE) {
	die('Error selecting the database\n');
}

$sql = "CREATE TABLE users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30),
	apellido VARCHAR(30),
	email VARCHAR(50) NOT NULL UNIQUE KEY,
	password VARCHAR(50) NOT NULL,
	usuario VARCHAR(50) NOT NULL UNIQUE KEY,
	dni VARCHAR(10),
	nacionalidad VARCHAR(30),
	nacimiento VARCHAR(10),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
	die('Error creating the table');
}

$sql = "INSERT INTO users (email, password, usuario) VALUES ('admin', 'admin', 'admin')";

if ($conn->query($sql) !== TRUE) {
	die('Error creando el usuario admin');
}

$conn->close();
