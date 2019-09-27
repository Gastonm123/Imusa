<?php

include_once 'database.php';
include_once 'usuario.php';
include_once 'perro.php';
include_once 'utils.php';

$db = new Database();

if ($db->error) {
	echo "<h1>$db->error</h1>";
	die;
}

// TODO morir si la instancia db no fue creada bien

$user = $password = '';
$GLOBALS['errores'] = [];


if (!isset($_COOKIE['user']) && $_SERVER["REQUEST_METHOD"] == 'POST') {
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
		$data = array('password' => $password, 'user' => $user);
		$GLOBALS['userType'] = $userType;

		if (validar_data($db, $data)) {
			setcookie('user', $user, time() + (10 * 365 * 24 * 60 * 60), '/');
			die('
			<script>
				location.href = "./sesion.php"
			</script>
			');
		} else {
			echo $db->error;
			die;
		}
	}

	if (!empty($GLOBALS['errores'])) {
		$result = '';

		foreach ($GLOBALS['errores'] as $error) {
			$result .= $error . '\n';
		}

		setcookie('errores', $result, time() + 20);
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['commands'])) {
		switch ($_GET['commands']) {
			case 'close':
			setcookie('user', '', time() - 3600, '/');
			die;
		}
	}
}

// TODO agregar validacion desde el servidor para la contraseña
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
	<link rel="stylesheet" href="../css/sesion.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/sesion.js"></script>
	<script src='../js/sticky_nav.js'></script>
	<link rel="shortcut icon" href="../img/logo.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
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

	<?php if (isset($_COOKIE['flash'])) : ?>
		<div style="display:flex; justify-content:center">
			<div class="w3-container w3-border-green w3-round" style="background-color:#c3e6cb; width:350px">
				<span style="color: #28a745 !important">
					<?php echo $_COOKIE['flash'] ?>
				</span>
			</div>
		</div>

		<?php setcookie('flash', '', time()-100, '/') ?>
	<?php endif; ?>

	<?php if (!isset($_COOKIE['user'])) : ?>
		
		<article>
			<div class="w3-card-4 w3-white container">
				<div class="w3-green w3-container">
					<h4 style="margin-left: 15px">Inicio de sesion</h4>
				</div>

				<script>
					function mandar_form(){
						var data = {
							user: $('#user').val(),
							password: $('#pass').val()
						}

						$("#waiting-spinner").css('display', 'inline-block');
						$("#sesion-text").css('display', 'none');
						$("#waiting-spinner").addClass('w3-spin');
						$.post(
							'./sesion.php', 
							data,
							function(a,b,c) {
								location.href = './sesion.php'
						})
					}
				</script>
				<div class="w3-padding-small">

					Usuario:
					<input id="user" class="w3-input w3-border" type="text">
					Password:
					<input id="pass" class="w3-input w3-border" type="password">

				</div>
				<div id="submit-box" style="float:left">
					<button class="w3-btn w3-teal" onclick="location.href= 'registrarse.php'">Registrarse</button>
					<button class="w3-btn w3-teal" onclick="mandar_form()" style="width:78px">
						<span id="sesion-text"> Sesion </span> 
						<i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
					</button>
				</div>
			</div>
		</article>

		<?php if (isset($_COOKIE['errores'])) : ?>
			<?php setcookie('errores', '', time()-3600) ?>
			<script>
				alert('<?php echo $_COOKIE['errores'] ?>');
			</script>
		<?php endif; ?>
	<?php else : ?>
		<script>
			function cerrar_cuenta() {
				var data = {
					commands: 'close'
				}

				$.get('./sesion.php', data, function(a,b,c) {
					location.href = './sesion.php'
				})
			}
		</script>

		<div class="w3-container index-content" style="display: flex; height: auto">
			<div class="w3-bar-block w3-green w3-round" style="width:300px; height:auto; float:left;">
				<div class="w3-padding" style="width: auto; height:auto; display:flex; justify-content:center">
					<img src="../img/usuario.png" style="width: 100px; height: 100px">
				</div>
				
				<div class='w3-bar-item w3-margin-top w3-margin-bottom'>
					<b>Mi cuenta</b> <br>
					¡Hola <?php echo $_COOKIE['user'] ?>!
				</div>

				<a href="./sesion.php" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-home icon"></i>HOME
				</a>
				<a href="./sesion.php?view=user" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-user icon"></i>USER
				</a>
				<a href="#" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-envelope icon"></i>ENVELOPE
				</a>
				<?php if (get_user_permission($db, $_COOKIE['user']) == 'admin') : ?>
					<a href='./sesion.php?view=accounts' class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
						<i class="fa fa-users icon"></i>ACCOUNTS
					</a>
				<?php endif; ?>
				<a href="./sesion.php?view=pets" class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-paw icon"></i>MASCOTAS
				</a>
				<button onclick='cerrar_cuenta()' class="w3-bar-item w3-button w3-margin-top w3-margin-bottom">
					<i class="fa fa-sign-out icon"></i>CERRAR SESION
				</button>
			</div>

			<?php if (!isset($_GET['view'])) : ?>
				<div class="w3-pale-yellow w3-round w3-padding" style="width: 100%; height: auto; text-align:justify">
					<div style="overflow-y:auto; height: auto">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum volutpat ultricies velit a consequat. Curabitur varius turpis sit amet bibendum fringilla. Sed imperdiet enim vel vulputate scelerisque. Curabitur cursus quam vel consectetur feugiat. Mauris id porttitor felis. Sed eu lectus et nisl lacinia pulvinar. Integer mattis neque dolor, eget dignissim dolor vehicula at. Mauris fermentum eu turpis nec eleifend. Sed ut ullamcorper libero, a molestie nunc. Maecenas dolor eros, malesuada vel tristique vitae, consectetur eget mauris.</p>

						<p>Maecenas a laoreet velit. Aliquam ultrices fringilla tortor maximus iaculis. Nunc eu dui luctus, consectetur risus nec, pulvinar nisl. Vivamus vulputate dolor bibendum sapien viverra bibendum. Vivamus varius nisl tortor, lacinia dictum orci scelerisque in. Vestibulum pretium scelerisque quam, vel maximus purus. Praesent auctor nisi non risus imperdiet, non pharetra risus ullamcorper. Fusce maximus id lorem vitae tincidunt. Nunc tempor tempus dapibus. Nullam pellentesque turpis eget odio hendrerit gravida. Morbi egestas risus magna, non lacinia turpis accumsan blandit. Ut commodo, diam nec auctor dapibus, erat odio volutpat orci, efficitur interdum neque mauris lobortis turpis. Phasellus porttitor elit et leo scelerisque vulputate. Vivamus sollicitudin, nisi id ultricies dapibus, justo lorem commodo nibh, non viverra lacus urna quis erat.</p>

						<p>Phasellus a libero nisl. Nullam quis felis et arcu blandit commodo. Etiam semper malesuada erat, quis finibus lorem pretium id. Vivamus felis tellus, vehicula ac nunc dapibus, placerat accumsan nisi. Duis eu arcu felis. Pellentesque elit neque, varius ut placerat a, finibus a tortor. Etiam est odio, aliquet eget scelerisque id, lacinia eu dolor. Vivamus porttitor elit vitae lorem commodo pellentesque.</p>

						<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam erat volutpat. Morbi mollis sem nibh, a facilisis enim pharetra tristique. Ut nec bibendum ex. Nam faucibus malesuada tellus, vel tempor diam. Donec cursus ipsum id erat rutrum, sit amet malesuada metus consectetur. Praesent tempor, nisl vel efficitur euismod, arcu ante aliquam mauris, eu vestibulum nibh justo a leo. Etiam semper urna vel lectus congue pulvinar. Donec vitae tempus neque, nec egestas leo. Mauris luctus ipsum id nisi efficitur iaculis. Praesent egestas ultrices est ac condimentum. Aliquam molestie neque rhoncus mauris ultricies, et vestibulum felis facilisis. Nam malesuada mauris tincidunt, placerat lorem vel, eleifend enim. Curabitur lacus tellus, interdum in nisi non, vulputate bibendum mi. Nunc pretium leo mattis, gravida tortor eu, maximus nibh.</p>

						<p>Praesent at leo sit amet dolor sagittis mattis. Cras blandit dictum sem, quis mattis ligula lacinia sit amet. Aenean aliquet cursus fermentum. Donec porta enim sit amet felis ullamcorper volutpat. Donec tristique mi eget enim sollicitudin tempus. Aliquam sollicitudin purus vitae tortor ullamcorper, et posuere enim auctor. Nunc at felis tempus, mattis justo non, efficitur nisl. Pellentesque vitae pellentesque sapien. Quisque neque purus, rhoncus a volutpat eu, euismod id leo.</p>
					</div>	
				</div>
			<?php elseif (get_user_permission($db, $_COOKIE['user']) == 'admin' && $_GET['view'] == 'accounts') : ?> 
				<div class="w3-pale-yellow w3-round w3-padding" style="width: 100%; height: auto; text-align:justify">
					<div style="display:flex; justify-content:center; margin-bottom:20px">
						<h2>
							USUARIOS
						</h2>
					</div>		
				
					<table class="w3-table w3-striped w3-white w3-hoverable" style="line-height:2.0; margin-bottom: 8px">
						<?php
						$offset = getOffset();

						$usuario = new Usuario(['db' => $db]);

						$result = $usuario->vistaArbol($offset);
						?>
					</table>
					
					<button style="float:right"
						class="w3-hide w3-button w3-light-blue guardar-btn"
						onclick="guardar()">Guardar</button>

					<span style="float:left; padding-left:2px"> Showing <?php echo $result->num_rows ?> out of 10 </span>
					<span style="float:right"> 
					<?php
					# flechitas
					vistaOffset($result);
					?>
					</span>

					<script>
						var dropdowns = $(".permissions-dropdown");
						var cambios = [];
						// configuramos un onclick para cada cuenta
						
						for (let i = 0; i < dropdowns.length; i++) {
							const dropdown = dropdowns[i];
							
							$(dropdown).hover(
							function() {
								var content = dropdown.children[1];
								if (content.className.indexOf("w3-show") == -1) {
									content.className += " w3-show";
								}
							}, function () {
								var content = dropdown.children[1];
								if (content.className.indexOf("w3-show") != -1) {
									content.className = content.className.replace(" w3-show", "");
								}
							});
						}
						
						function setear(usuario, permiso) {
							var accounts = $('.account');
							var account_id = +accounts[usuario].children[0].innerHTML;

							var posicion_permiso = <?php echo $result->rol_column ?>

							var tr_permiso = accounts[usuario].children[posicion_permiso];

							tr_permiso.children[0].innerHTML = permiso;

							cambios[account_id] = permiso; 

							//mostrar el boton de guardar
							var guardar_btn = $(".guardar-btn")[0];
							if (guardar_btn.className.indexOf('w3-hide') != -1) {
								guardar_btn.className = guardar_btn.className.replace("w3-hide", "");
							}
						}

						function guardar() {
							cambios.forEach((element, index) => {
								var data = {
									'uid': index,
									'table': 'permissions',
									'rol': element
								}

								$.post('update_user_data.php', data, function(a,b,c){
									console.log("actualizada info del user " + index);
								})
							});

							cambios = [];

							var guardar_btn = $(".guardar-btn")[0];
							guardar_btn.className = 'w3-hide' + guardar_btn.className; 
						}
					</script>
				</div>
			<?php elseif ($_GET['view'] == 'pets') : ?>
				<div class="w3-pale-yellow w3-round w3-padding" style="width: 100%; height: auto; text-align:justify">
					<div style="display:flex; justify-content:center; margin-bottom:20px">
						<h2> MASCOTAS </h2>
					</div>

					<table class="w3-table w3-striped w3-white w3-hoverable" style="line-height:2.0">
						<?php
						$offset = getOffset();

						$perro = new Perro(['db' => $db]);

						$result = $perro->vistaArbol($offset);
						?>
					</table>
					<span style="float:left; padding-left:2px"> Showing <?php echo $result->num_rows ?> out of 10 </span>
					<span style="float:right"> 
					<?php
					# flechitas
					vistaOffset($result);
					?>
					</span>
				</div>
			<?php else : ?>
				<?php 
					$user_id = get_user_id($db, $_COOKIE['user']);
					$result = $db->getUserInfo($user_id);

					if ($db->error == FALSE) {
						$name = $result['name'];
						$surname = $result['surname'];
						$birthdate = $result['birthdate'];
						$nacionality = $result['nacionality'];
						$description = $result['description'];
						$arr = [
							'name' => $name, 
							'surname' => $surname, 
							'birthdate' => $birthdate, 
							'nacionality' => $nacionality, 
							'description' => $description
						];
					} else {
						echo '
						<script>
							alert(\'No se ha podido cargar el perfil de usuario\');
							location.href = \'./sesion.php\'
						</script>';
					}
				?>

				<?php if ($_GET['view'] == 'user') : ?>

					<div class="w3-pale-yellow w3-round w3-padding" style="width: 100%; height: auto; text-align:justify">
						<div style="display:block; margin-bottom:30px">
							<div class="w3-padding" style="float:right; height:auto; width: auto">
								<img src="../img/usuario.png" style="width: 100px; height: 100px">
							</div>
							<div>
								<h2>Usuario</h2>
								<h3 class="w3-margin"> <?php echo $_COOKIE['user'] ?> </h3>
							</div>
						</div>
						<div class="w3-padding">
							Nombre <br>
							<?php echo $name ?> <br>
							Apellido <br>
							<?php echo $surname ?> <br>
							Cumpleaños <br>
							<?php echo $birthdate ?> <br>
							Nacionalidad <br>
							<?php echo $nacionality ?> <br>
							Descripcion <br>
							<?php echo $description ?> <br>
						</div>
						<button class='w3-btn w3-cyan' style='float:right; margin-top:20px'
							onclick="location.href = './sesion.php?view=user-edit'">Editar</button>
					</div>

				<?php elseif ($_GET['view'] == 'user-edit') : ?>
					<script>
						var previous_values = {};

						<?php foreach ($arr as $key => $value) {
							if (!empty($value)) {
								echo 'previous_values[\''.$key.'\'] = \''.$value.'\';';
							}
						} ?>

						function mandar_user_data() {
							var data = {};
							var user_data = $('.user-data');

							for (let i = 0; i < user_data.length; i++) {
								let field = user_data[i];
								if (field.value != previous_values[field.name]) {
									data[field.name] = field.value;
								}
							}

							data['uid'] = <?php echo get_user_id($db, $_COOKIE['user']) ?>;
							data['table'] = 'users_info';
							
							$("#waiting-spinner").css('display', 'inline-block');
							$("#terminar-text").css('display', 'none');
							$("#waiting-spinner").addClass('w3-spin');
							$.post('update_user_data.php', data,
								function (data, status, xhr) {
									location.href = './sesion.php?view=user';
							})
						}
					</script>
					
					<div class="w3-pale-yellow w3-round w3-padding" style="width: 100%; height: auto; text-align:justify">
						<div style="display:block; margin-bottom:30px">
							<div class="w3-padding" style="float:right; height:auto; width: auto">
								<img src="../img/usuario.png" style="width: 100px; height: 100px">
							</div>
							<div>
								<h2>Usuario</h2>
								<h3 class='w3-margin'> <?php echo $_COOKIE['user'] ?> </h3>
							</div>
						</div>
						<div class="w3-padding">
							Nombre <br>
							<input type="text" class="w3-input user-data" name="name" value="<?php echo $name ?>">
							Apellido <br>
							<input type="text" class="w3-input user-data" name="surname" value="<?php echo $surname ?>">
							Cumpleaños <br>
							<input type="date" class="w3-input user-data" name="birthdate" value="<?php echo $birthdate ?>">
							Nacionalidad <br>
							<input type="text" class="w3-input user-data" name="nacionality" value="<?php echo $nacionality ?>">
							Descripcion <br>
							<input type="text" class="w3-input user-data" name="description" value="<?php echo $description ?>">
							
							<button onclick="mandar_user_data()" 
								class="w3-btn w3-cyan" style="float:right; margin-top:20px">
								<span id="terminar-text"> TERMINAR </span> 
								<i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
							</button>
						</div>
					</div>
				<?php else : ?>
					<script>
						alert('Su pagina no se pudo cargar');
						location.href = './sesion.php';
					</script>
				<?php endif; ?>
			<?php endif;?>
		</div>
	<?php endif; ?>
</body>

</html>

<?php $db->cerrar(); ?>
