<?php
// esta plantilla requiere de la existencia de las siguientes variables globales
$name = $GLOBALS['name'];
$surname = $GLOBALS['surname'];
$birthdate = $GLOBALS['birthdate'];
$nacionality = $GLOBALS['nacionality'];
$description = $GLOBALS['description'];
$complete_name = $GLOBALS['complete_name'];

// ademas para una visualizacion correcta se deben incluir los archivos w3.css, sesion.css
?>

<div class="form-header">
    <div style="display:flex">
        <div class="header-image">
            <img src="../img/usuario.png" style="width: 100px; height: 100px">
        </div>
        <div class="header-content">
            <h3><?php echo $complete_name ?></h3>
            <button class='w3-btn w3-blue' onclick="location.href = './sesion.php?view=user-edit'">Editar Perfil</button>
        </div>
    </div>
</div>

<div class="form-content">
    <?php if (isset($_GET['view']) && $_GET['view'] == 'user-edit') : ?>
        <input type="text" class="w3-input form-slot" name="name" placeholder="<?php echo $name ?>">
        <input type="text" class="w3-input form-slot" name="surname" placeholder="<?php echo $surname ?>">
        <input type="text" class="w3-input form-slot" name="birthdate" placeholder="<?php echo $birthdate ?>">
        <input type="text" class="w3-input form-slot" name="nacionality" placeholder="<?php echo $nacionality ?>">
        <input type="text" class="w3-input form-slot" name="description" placeholder="<?php echo $description ?>">
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