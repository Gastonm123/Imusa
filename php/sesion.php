<?php

$user = $password = '';
$GLOBALS['errores'] = [];

function format_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if (!isset($_COOKIE['user'])) {
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
				setcookie('user', $user, time() + (10 * 365 * 24 * 60 * 60), '/');
			}
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (!empty($_GET['commands'])) {
		switch ($_GET['commands']) {
			case 'close':
				setcookie('user', '', time() - 3600, '/');
				die;
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="../lib/jquery-3.3.1.min.js"></script>
	<script src="../js/sesion.js"></script>
	<script src='../js/sticky_nav.js'></script>
</head>

<body class="w3-blue">
	<header class="w3-padding-small w3-section w3-row header-container w3-cyan w3-text-white">
		<div class="w3-row" style="width:10%; min-width:100px">
			<img src="../img/logo.jpeg" style="width:100px">
		</div>
		<div class="w3-row" style="width:20%; margin-left: 20px">
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

	<?php if (!isset($_COOKIE['user'])) : ?>
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
		<script>
			function cerrar_cuenta() {
				$.get('./sesion.php', {
					commands: 'close'
				})
				location.href = './sesion.php'
			}
		</script>

		<div class="w3-container index-content" style="height: 800px">
			<div class="w3-bar-block w3-green w3-round" style="width:300px; height:100%; float:left;">
				<div class="w3-padding" style="width: 100%; height:auto; display:flex; justify-content:center">
					<img src="../img/usuario.png" style="width: 100px; height: 100px">
				</div>
				
				<div class='w3-bar-item w3-margin-top w3-margin-bottom'>
					<b>Mi cuenta</b> <br>
					¡Hola <?php echo $_COOKIE['user'] ?>!
				</div>

				<a href="#" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-home icon"></i>HOME
				</a>
				<a href="#" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-search icon"></i>SEARCH
				</a>
				<a href="#" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-envelope icon"></i>ENVELOPE
				</a>
				<a href="#" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-globe icon"></i>WEB
				</a>
				<button onclick='cerrar_cuenta()' class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-sign-out icon"></i>CERRAR SESION
				</button>
			</div>
			<div class="w3-pale-yellow w3-round w3-padding" style="width: 100%; height: 100%; padding-left: 310px !important; text-align:justify">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum volutpat ultricies velit a consequat. Curabitur varius turpis sit amet bibendum fringilla. Sed imperdiet enim vel vulputate scelerisque. Curabitur cursus quam vel consectetur feugiat. Mauris id porttitor felis. Sed eu lectus et nisl lacinia pulvinar. Integer mattis neque dolor, eget dignissim dolor vehicula at. Mauris fermentum eu turpis nec eleifend. Sed ut ullamcorper libero, a molestie nunc. Maecenas dolor eros, malesuada vel tristique vitae, consectetur eget mauris.</p>

				<p>Maecenas a laoreet velit. Aliquam ultrices fringilla tortor maximus iaculis. Nunc eu dui luctus, consectetur risus nec, pulvinar nisl. Vivamus vulputate dolor bibendum sapien viverra bibendum. Vivamus varius nisl tortor, lacinia dictum orci scelerisque in. Vestibulum pretium scelerisque quam, vel maximus purus. Praesent auctor nisi non risus imperdiet, non pharetra risus ullamcorper. Fusce maximus id lorem vitae tincidunt. Nunc tempor tempus dapibus. Nullam pellentesque turpis eget odio hendrerit gravida. Morbi egestas risus magna, non lacinia turpis accumsan blandit. Ut commodo, diam nec auctor dapibus, erat odio volutpat orci, efficitur interdum neque mauris lobortis turpis. Phasellus porttitor elit et leo scelerisque vulputate. Vivamus sollicitudin, nisi id ultricies dapibus, justo lorem commodo nibh, non viverra lacus urna quis erat.</p>

				<p>Phasellus a libero nisl. Nullam quis felis et arcu blandit commodo. Etiam semper malesuada erat, quis finibus lorem pretium id. Vivamus felis tellus, vehicula ac nunc dapibus, placerat accumsan nisi. Duis eu arcu felis. Pellentesque elit neque, varius ut placerat a, finibus a tortor. Etiam est odio, aliquet eget scelerisque id, lacinia eu dolor. Vivamus porttitor elit vitae lorem commodo pellentesque.</p>

				<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam erat volutpat. Morbi mollis sem nibh, a facilisis enim pharetra tristique. Ut nec bibendum ex. Nam faucibus malesuada tellus, vel tempor diam. Donec cursus ipsum id erat rutrum, sit amet malesuada metus consectetur. Praesent tempor, nisl vel efficitur euismod, arcu ante aliquam mauris, eu vestibulum nibh justo a leo. Etiam semper urna vel lectus congue pulvinar. Donec vitae tempus neque, nec egestas leo. Mauris luctus ipsum id nisi efficitur iaculis. Praesent egestas ultrices est ac condimentum. Aliquam molestie neque rhoncus mauris ultricies, et vestibulum felis facilisis. Nam malesuada mauris tincidunt, placerat lorem vel, eleifend enim. Curabitur lacus tellus, interdum in nisi non, vulputate bibendum mi. Nunc pretium leo mattis, gravida tortor eu, maximus nibh.</p>

				<p>Praesent at leo sit amet dolor sagittis mattis. Cras blandit dictum sem, quis mattis ligula lacinia sit amet. Aenean aliquet cursus fermentum. Donec porta enim sit amet felis ullamcorper volutpat. Donec tristique mi eget enim sollicitudin tempus. Aliquam sollicitudin purus vitae tortor ullamcorper, et posuere enim auctor. Nunc at felis tempus, mattis justo non, efficitur nisl. Pellentesque vitae pellentesque sapien. Quisque neque purus, rhoncus a volutpat eu, euismod id leo.</p>
			</div>
		</div>
	<?php endif; ?>
</body>

</html>