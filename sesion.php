<?php

/* establecer la conexion y checkear que se haya enviado un formulario */

if(!$_POST) {
    echo "Error, ningun formulario fue enviado";
    exit;
}

mysqli_report(MYSQLI_REPORT_STRICT);

try {
    $con = new mysqli("localhost", "gaston", "1234", "imusa");
} catch (Exception $e) {
    echo 'Error de conexion';
    exit;
}


/* checkear que exista la combinacion de usuario y contrasenia */
$USER = $_POST['user'];
$PASS = $_POST['pass'];

$query = "SELECT * FROM usuarios WHERE username='$USER' AND password=SHA1('$PASS')";

$ans = $con->query($query);

if(!$ans){
    die($con->error);
}

if($ans->num_rows){
    #setear usuario en el servidor
    echo 'Sesion Iniciada';
} else {
    echo 'Password o usuario incorrectas';
}

$con->close()

?>