<?php

if (isset($_POST['usuario'])) {
	include_once 'database.php';
	include_once 'usuario.php';

	function flash($mensaje) { // TODO volver a implementar esto
		setcookie("flash", $mensaje, time()+60, "/");
		die;
	}
	
	$db = new Database();

	if ($db->error) {
        echo $db->error;
		die;
	}
	
	$usuarioPost = $_POST['usuario'];
	$username = $usuarioPost['username'];
	$password = $usuarioPost['password'];
	$email    = $usuarioPost['email'];
	
	$usuario = new Usuario(['username'=>$username, 'password'=>$password, 'email'=>$email]);
	
    $result = $db->crearUser($usuario);
    
    if ($db->error) {
        echo $db->error;
        die;
    }

	$db->cerrar();
	die;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>IMuSA Sitio Web</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../css/document.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/registrarse.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/sticky_nav.js"></script>
    <script src="../js/registro.js"></script>
    <link rel="shortcut icon" href="../img/logo.ico"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="w3-blue">
    <header class="w3-padding-small w3-section w3-row header-container w3-cyan w3-text-white">
        <div class="w3-row" style="width:10%; min-width:100px">
            <img src="../img/logo.jpeg" style="width:100px">
        </div>
        <div class="w3-row" style="width:20%; margin-left:20px">
            Instituto Municipal de Salud Animal
        </div>
        <div class="w3-row" style="width:50%"></div>
        <div class="w3-row w3-xlarge w3-right-align" style="width:20%">
            IMuSA
        </div>
    </header>

    <nav id="navbar" class="w3-container w3-row" style="padding:0px">
        <button onclick="location.href='../index.html'"
            class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="inicio" class="center-item">
            INICIO
        </button>
        <button onclick="location.href='tratamiento.html'"
            class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="contacto" class="center-item">
            TRATAMIENTO
        </button>
        <button onclick="location.href='adopcion.html'"
            class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="adopcion" class="center-item">
            ADOPCION
        </button>
        <button onclick="location.href='../php/sesion.php'"
            class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="sesion" class="center-item">
            SESION
        </button>
    </nav>

    <article class="w3-margin w3-card-4 w3-white" style="width:50%">
        <div class="w3-container w3-green">
            <h3>Registro</h3>
        </div>

        <div class="w3-container w3-padding">
            <h4>Complete los siguientes campos para concretar el registro</h4>

            Email: <br> <input class="w3-input" type="email" name="mail" required>
            Username: <br> <input class="w3-input" type="text" name="username" required>
            Password: <br> <input class="w3-input" type="password" name="password" required>
            Repita password: <br> <input class="w3-input" type="password" id="confirm" required>

            <div class="w3-container w3-padding" style="display:flex; justify-content: center">
                <button id="finalizar" class="w3-btn w3-teal" style="width:88px">
                    <span id="btn-text"> Finalizar </span>
					<i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
                </button>
            </div>
        </div>
    </article>
</body>

</html>