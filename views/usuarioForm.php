<?php
// TODO agregar la opcion de que los admins cambien las contrasenias, usuarios y emails de los usuarios 

// esta plantilla requiere de la existencia de las siguientes variables globales
$id = $GLOBALS['id'];

$name = $GLOBALS['name'];
$surname = $GLOBALS['surname'];
$birthdate = $GLOBALS['birthdate'];
$nacionality = $GLOBALS['nacionality'];
$description = $GLOBALS['description'];
if (empty($name) && empty($surname)) {
    $complete_name = $GLOBALS['username'];
} else {
    $complete_name = "$name $surname";
}
$edicion = (isset($_GET['view']) && $_GET['view'] == 'user-edit');
// ademas para una visualizacion correcta se deben incluir los archivos w3.css, sesion.css
?>

<!-- <head>
    <link rel="stylesheet" href="../css/sesion.css">
    <link rel="stylesheet" href="../css/w3.css">
</head> -->
<div class="header w3-round">
    <?php if ($edicion) : ?>
        <a  class="go-back w3-blue w3-btn"
            href="./sesion.php?view=user"><i class="fa fa-arrow-left"></i></a>
    <?php else: ?>
        <a  class="go-back w3-blue w3-btn" style="visibility:hidden"
            href="./sesion.php?view=user"><i class="fa fa-arrow-left"></i></a>
    <?php endif; ?>


    <div class="form-header">
        <div style="display:flex">
            <div class="header-image">
                <img src="../img/usuario.png" style="width: 100px; height: 100px">
            </div>
            <div class="header-content">
                <h3><?php echo $complete_name ?></h3>
                <?php if ($edicion) : ?>
                    <button class="w3-btn w3-blue" onclick="alert('jajaja')">Cambiar foto</button>
                <?php else : ?>
                    <?php if ($GLOBALS['user_permission'] == 'admin' && isset($_GET['id'])) : ?>
                        <button class='w3-btn w3-blue' 
                            onclick="location.href='./sesion.php?view=user-edit&id=<?php echo $_GET['id'] ?>'">
                            Editar Perfil
                        </button>
                        <button class="w3-btn w3-blue"
                            onclick="alert('Aca vas a poder cambiar contrasenia, usuario, email.. Algun dia')">
                            Configuracion
                        </button>
                    <?php else : ?>
                        <button class='w3-btn w3-blue' 
                            onclick="location.href='./sesion.php?view=user-edit'">
                            Editar Perfil
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="form-content w3-round">
    <?php if ($edicion) : ?>
        <input type="text" class="w3-input form-slot" name="name" placeholder="Nombre: <?php echo $name ?>">
        <input type="text" class="w3-input form-slot" name="surname" placeholder="Apellido: <?php echo $surname ?>">
        <div class="w3-input date-container">
            <span class="date-span">
                Fecha Nacimiento: <input type="date" class="form-slot no-input" name="birthdate" value="<?php echo $birthdate ?>">
            </span>
        </div>
        <input type="text" class="w3-input form-slot" name="nacionality" placeholder="Nacionalidad: <?php echo $nacionality ?>">
        <input type="text" class="w3-input form-slot" name="description" placeholder="Descripcion: <?php echo $description ?>">
        <button onclick="mandar_user_data(<?php echo $id ?>)" 
            class="w3-btn w3-blue" style="float:right; margin-top:20px">
            <span id="terminar-text"> Terminar </span> 
            <i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
        </button>
    <?php else : ?>
        <div class="w3-input form-slot">
            <span style="float: left">Nombre</span>
            <span style="float:right"><?php echo $name ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Apellido</span>
            <span style="float:right"><?php echo $surname ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Cumpleaños</span>
            <span style="float:right"><?php echo $birthdate ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Nacionalidad</span>
            <span style="float:right"><?php echo $nacionality ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float:left">Descripcion</span>
            <span style="float:right"><?php echo $description ?></span>
        </div>
    <?php endif; ?>
</div>