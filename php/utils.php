<?php

function validar_data($db, $data)
{
	$fields = ['password' => $data['password']];

	//user data could be username or email
	if ($GLOBALS['userType'] == 'email') {
		$fields['email'] = $data['user'];
	} else if ($GLOBALS['userType'] == 'username') {
		$fields['username'] = $data['user'];
	}
	
	$result = $db->getUser($fields);

	if ($db->error == FALSE) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function format_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function get_user_id($db, $user) 
{
	$result = $db->getUser(['username'=>$user]);

	if ($db->error == FALSE) {
		return $result['id'];
	} else {
		return FALSE;
	}
}

function get_user_permission($db, $user)
{
	$id = $get_user_id($user);

	$result = $db->getUserInfo($id);

	if ($db->error == FALSE) {
		return $result['rol'];
	} else {
		return FALSE;
	}
}