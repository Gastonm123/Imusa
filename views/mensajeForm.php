<?php
$id = $GLOBALS['id'];
$mensaje = $GLOBALS['mensaje'];

$emisor = $mensaje['emisor'];
$tipo = $mensaje['tipo'];
$asunto = $mensaje['asunto'];
$contenido = $mensaje['contenido'];

if (empty($tipo)) {
    $tipo = 'MENSAJE';
}

if (empty($emisor)) {
    $emisor = $GLOBALS['username'];
}

$edicion = (isset($_GET['view']) && $_GET['view'] == 'mensajeEdit');
?>  

<!-- <head>
    <link rel="stylesheet" href="../css/sesion.css">
    <link rel="stylesheet" href="../css/w3.css">
</head> -->

<div class="header w3-round">
    <?php if ($edicion) : ?>
        <a  class="go-back w3-blue w3-btn" style="visibility:hidden"
            href="./sesion.php?view=mensaje"><i class="fa fa-arrow-left"></i></a>
    <?php else: ?>
        <a  class="go-back w3-blue w3-btn"
            href="./sesion.php?view=mensajeTree"><i class="fa fa-arrow-left"></i></a>
    <?php endif; ?>


    <div class="form-header">
        <div style="display:flex; align-items:center">
            <div class="header-image">
                <img src="../img/mail.png" style="width: 100px; height: 70px">
            </div>
            <div class="header-content">
                <?php if ($edicion) : ?>
                    <span style="font-size:20px">Tipo</span> <br>
                    <h3 style="color:#2196f3; margin:0"><?php echo $tipo ?></h3> 
                <?php else : ?>
                    <?php if ($GLOBALS['user_permission'] == 'admin' && isset($_GET['id'])) : ?>
                        <h3 style="margin:0"><?php echo $tipo ?></h3>
                        <button class='w3-btn w3-blue' 
                            onclick="location.href='./sesion.php?view=mensajeEdit&id=<?php echo $id ?>'">
                            Editar Mensaje
                        </button>                  
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="form-content w3-round">
    <?php if ($edicion) : ?>
    <input type="text" class="w3-input form-slot" name="asunto" placeholder="Asunto: <?php echo $asunto ?>">
    <input type="text" class="w3-input form-slot" name="contenido" placeholder="Contenido: <?php echo $contenido ?>">
    <input type="text" class="w3-input form-slot" name="emisor" style="display:none" value="<?php echo $emisor ?>">
    <input type="text" class="w3-input form-slot" name="tipo" style="display:none" value="<?php echo $tipo ?>">
        
        <?php if (isset($id)) : ?>
        <button onclick="actualizar_mensaje(<?php echo $id ?>)" 
            class="w3-btn w3-blue" style="float:right; margin-top:20px">
        <?php else : ?>
        <button onclick="crear_mensaje()" id="btn-container"
            class="w3-btn w3-blue" style="float:right; margin-top:20px">
        <?php endif; ?>
            <span id="terminar-text"> Terminar </span> 
            <i class="fa fa-spinner" style="display:none" id="waiting-spinner"></i>
        </button>
    <?php else : ?>
        <div class="w3-input form-slot">
            <span style="float: left">Emisor</span>
            <span style="float:right"><?php echo $emisor ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Asunto</span>
            <span style="float:right"><?php echo $asunto ?></span>
        </div>
        <div class="w3-input form-slot">
            <span style="float: left">Contenido</span>
            <span style="float:right"><?php echo $contenido ?></span>
        </div>
    <?php endif; ?>
</div>