<?php

function validar_data($data)
{
	include('datos.php');

	$conn = new mysqli($servername, $username, $password, $db);

	if ($conn->connect_error) {
		array_push($GLOBALS['errores'], 'Batabase connection error');
		return FALSE;
	}

	//user data could be username or email
	if ($GLOBALS['userType'] == 'email') {
		$sql = 'SELECT * FROM users WHERE email=\'' . $data['user'] . '\'';
	} else if ($GLOBALS['userType'] == 'username') {
		$sql = 'SELECT * FROM users WHERE username=\'' . $data['user'] . '\'';
	}

	$sql .= ' AND password=SHA1(\'' . $data["password"] . '\')';
	$response = $conn->query($sql);

	if ($response === FALSE || $response->num_rows == 0) {
		array_push($GLOBALS['errores'], "Failed login in");
		return FALSE;
	} else if ($response->num_rows > 1) {
		array_push($GLOBALS['errores'], 'Database corrupted');
		return FALSE;
	}

	return TRUE;
}


function format_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function get_username($user) 
{
	include 'datos.php';
	$conn = new mysqli($servername, $username, $password, $db);
	$sql = "SELECT username FROM users WHERE email='" . $user . "'";
	if ($result = $conn->query($sql)) {
		return $result->fetch_row()[0];
	} else {
		array_push($GLOBALS['errores'], 'Error obteniendo el nombre de usuario');
		return false;
	}
}

function get_user_id($user) 
{
	include 'datos.php';
	$conn = new mysqli($servername, $username, $password, $db);
	$sql = 'SELECT id FROM users WHERE username=\'' . $user . '\'';
	if ($result = $conn->query($sql)) {
		return $result->fetch_row()[0];
	} else {
		return false;
	}
}

function get_user_permission($user)
{
	include 'datos.php';
	$conn = new mysqli($servername, $username, $password, $db);
	$uid = get_user_id($user);
	$sql = 'SELECT rol FROM permissions WHERE uid=\'' . $uid . '\'';
	if ($result = $conn->query($sql)) {
		return $result->fetch_row()[0];
	} else {
		return false;
	}
}