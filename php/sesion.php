<?php

$user = $password = '';
$GLOBALS['errores'] = [];

if (empty($_SESSION)) {
	function format_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	if ($_SERVER["REQUEST_METHOD"] == 'POST') {
		if (empty($_POST['user'])) {
			array_push($GLOBALS['errores'], 'User or email is required');
		} else {
			$user = format_input($_POST["user"]);
			if (preg_match("/^[a-zA-Z 0-9_]*$/", $user)) {
				$userType = 'username';
			} else if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
				$userType = 'email';
			} else {
				array_push($GLOBALS['errores'], 'Invalid user or email');
			}
		}

		if (empty($_POST['password'])) {
			array_push($GLOBALS['errores'], 'Password is required');
		} else {
			$password = format_input($_POST["password"]);
		}

		if (empty($GLOBALS['errores'])) {
			include 'validaciones.php';
			$data = array('password' => $password, 'user' => $user);
			$GLOBALS['userType'] = $userType;

			if (validar_data($data)) {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['password'] = $password;
			}
		}
	}
}
?>

<!-- generar la pagina distinto dependiendo de que se haya creado una sesion o no -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>IMuSA Sitio Web</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/document.css">
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../css/sesion.css">
	<script type="text/javascript" src="../lib/jquery-3.3.1.min.js"></script>
	<script src="../js/sesion.js"></script>
	<script src='../js/sticky_nav.js'></script>
</head>

<body class="w3-blue">
	<header class="w3-padding-small w3-section w3-row header-container w3-cyan w3-text-white">
		<div class="w3-row" style="width:10%">
			<img src="../img/logo.jpeg" style="width:100px">
		</div>
		<div class="w3-row" style="width:20%">
			Instituto Municipal de Salud Animal
		</div>
		<div class="w3-row" style="width:50%"></div>
		<div class="w3-row w3-xlarge w3-right-align" style="width:20%">
			IMuSA
		</div>
	</header>

	<nav id="navbar" class="w3-container w3-row" style="padding:0px">
		<button onclick="location.href='../index.html'" class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="inicio" class="center-item">
			INICIO
		</button>
		<button onclick="location.href='../html/tratamiento.html'" class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="contacto" class="center-item">
			TRATAMIENTO
		</button>
		<button onclick="location.href='../html/adopcion.html'" class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="adopcion" class="center-item">
			ADOPCION
		</button>
		<button class="nav-item w3-btn w3-orange w3-hover-deep-orange w3-quarter" id="sesion" class="center-item">
			SESION
		</button>
	</nav>

	<?php if (empty($_SESSION)) : ?>
		<?php
		$result = '';

		foreach ($GLOBALS['errores'] as $error) {
			$result .= $error . '\n';
		}

		if (!empty($result)) {
			echo '<script>
					alert(\'' . $result . '\')
				</script>';
		}
		?>

		<article>
			<div class="w3-card-4 w3-white container">
				<div class="w3-green w3-container">
					<h4 style="margin-left: 15px">Inicio de sesion</h4>
				</div>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="w3-padding-small" id='form1'>

					Usuario:
					<input id="user" class="w3-input w3-border" type="text" name="user" value=<?php echo $user ?>>
					Password:
					<input id="pass" class="w3-input w3-border" type="password" name="password" value=<?php echo $password ?>>

				</form>
				<div id="submit-box" style="float:left">
					<button class="w3-btn w3-teal" onclick="location.href= '../html/registrarse.html'">Registrarse</button>
					<button class="w3-btn w3-teal" form='form1' type='submit'>Sesion</button>
				</div>
			</div>
		</article>
	<?php else : ?>
		<div class="w3-card w3-white">
			Bienvenido <?php echo $_SESSION['user'] ?> with password <?php echo $_SESSION['password'] ?>
		</div>
	<?php endif; ?>
</body>

</html>