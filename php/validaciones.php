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
		$sql = 'SELECT nombre FROM users WHERE email=\'' . $data['user'] . '\'';
	} else if ($GLOBALS['userType'] == 'username') {
		$sql = 'SELECT nombre FROM users WHERE usuario=\'' . $data['user'] . '\'';
	}

	$sql .= ' AND password=SHA1(\'' . $data["password"] . '\')';
	$response = $conn->query($sql);

	if ($response === FALSE || $response->num_rows == 0) {
		array_push($GLOBALS['errores'], 'Failed signing in');
		return FALSE;
	} else if ($response->num_rows > 1) {
		array_push($GLOBALS['errores'], 'Database corrupted');
		return FALSE;
	}

	return TRUE;
}
