<?php
include_once 'utils.php';
$edicion = (isset($_GET['view']) && $_GET['view'] == 'perro-edit');
$creacion = ($edicion && empty($_GET['id']));

if (!$creacion) {
    // obtener la informacion del perro con id $_GET['id']
    $perro = obtener_perro($_GET['id']);

    if (is_object($perro)) {
        $perro = $perro->fetch_assoc();
    } else {
        echo $perro['error'];
        die;
    }

    $id = $_GET['id'];
    $jaula = $perro['jaula'];
    $sexo = $perro['sexo'];
    $raza = $perro['raza'];
    $adoptabilidad = $perro['adoptabilidad'];
    $edad = $perro['edad'];
    $observaciones = $perro['observaciones'];
    $tag = "$jaula - $sexo";
} else {
    $tag = "Nuevo perro";
}
?>

<!-- <head>
<link rel="stylesheet" href="../css/sesion.css">
<link rel="stylesheet" href="../css/w3.css">
<script src='../js/database.js'></script>
</head> -->

<div class="form-header w3-round">
    <div style="display:flex">
        <div class="header-image">
            <img src="../img/logo_perro.png" style="width: 100px; height: 100px">
        </div>
        <div class="header-content">
            <h3><?php echo $tag ?></h3>
            <?php if ($edicion) : ?>
                <button class="w3-btn w3-blue" onclick="alert('jajaja')">Cambiar foto</button>
            <?php else : ?>
                <button class='w3-btn w3-blue' onclick="location.href = './sesion.php?view=perro-edit&id=<?php echo $id?>'">Editar Perro</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="form-content w3-round">
    <?php if ($edicion) : ?>
        <input type="text" class="w3-input form-slot" name="jaula" placeholder="Jaula: <?php echo $jaula ?>">
        <input type="text" class="w3-input form-slot" name="sexo" placeholder="Sexo: <?php echo $sexo ?>">
        <input type="text" class="w3-input form-slot" name="raza" placeholder="Raza: <?php echo $raza ?>">
        <input type="text" class="w3-input form-slot" name="adoptabilidad" placeholder="Adoptabilidad: <?php echo $adoptabilidad ?>">
        <input type="text" class="w3-input form-slot" name="edad" placeholder="Edad: <?php echo $edad ?>">
        <input type="text" class="w3-input form-slot" name="observaciones" placeholder="Observaciones: <?php echo $observaciones ?>">
        <?php if ($creacion) : ?>
            <button onclick="crear_perro()" 
                class="w3-btn w3-blue" style="float:right; margin-top:20px">
                <span id="terminar-text"> Terminar </span> 
                <i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
            </button>
        <?php else : ?>
            <button onclick="actualizar_perro(<?php echo $id ?>)" 
                class="w3-btn w3-blue" style="float:right; margin-top:20px">
                <span id="terminar-text"> Terminar </span> 
                <i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
            </button>
        <?php endif; ?>
    <?php else : ?>
        <div class="w3-input form-slot">
            <span style="float: left">Jaula</span>
            <span style="float:right"><?php echo $jaula ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Sexo</span>
            <span style="float:right"><?php echo $sexo ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Raza</span>
            <span style="float:right"><?php echo $raza ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Adoptabilidad</span>
            <span style="float:right"><?php echo $adoptabilidad ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float:left">Edad</span>
            <span style="float:right"><?php echo $edad ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float:left">Observaciones</span>
            <span style="float:right"><?php echo $observaciones ?></span>
        </div>
    <?php endif; ?>
</div>