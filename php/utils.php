<?php

include_once 'database.php';
include_once 'base.php';

function getOffset() 
{
	if (empty($_GET['offset'])) {
		$offset = 0;
	} else {
		$offset = $_GET['offset'];
	}

	return $offset;
}

function vistaOffset($result, $vista) 
{
	$offset = getOffset();

	if ($offset > 0) {
		if ($offset == 10) {
			$offset_msg = '';
		} else {
			$offset_msg = '&offset='.($offset-10);
		}

		echo "<a href='./sesion.php?view=$vista".$offset_msg."'><i class='fa fa-chevron-left icon'></i></a>";
	}
	echo $offset.'/'.($offset+10);
	if ($result->num_rows == 10) {
		echo "<a href='./sesion.php?view=$vista&offset=".($offset+10)."'><i style='margin-left:6px' class='fa fa-chevron-right icon'></i></a>";
	}
}

function validar_data($db, $data)
{
	$fields = ['password' => $data['password']];

	// user data could be username or email
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
	$result = $db->obtener_objeto('users', ['id'], ['username'=>$user]);

	if ($db->error == FALSE) {
		return $result->fetch_assoc()['id'];
	} else {
		return FALSE;
	}
}

function get_user_permission($db, $user)
{
	$id = get_user_id($db, $user);

	$result = $db->obtener_objeto('users_info', ['rol'], ["uid"=>$id]);

	if ($db->error == FALSE) {
		return $result->fetch_assoc()['rol'];
	} else {
		return FALSE;
	}
}

function obtener_perro($id) 
{
	$campos = ['jaula','sexo','raza','adoptabilidad','edad','observaciones'];
	$db = new Database();

	$result = $db->obtener_objeto('perros', $campos, ['id'=>$id]);
	
	$db->cerrar();
	if ($db->error) {
		return ['error' => $db->error];
	} else {
		return $result;
	}

}