<?php /* Custom Template Name: Mis gallos New*/?>

<?php
    include_once 'functions.php';
    include_once 'Classes/gallos.php';
    include_once 'Classes/queries.php';
    include_once 'local_folder.php';

    $thrownMessage = null;
    $agregarGalloLink = goToUrl('guardar-gallo');

    try {
        $queries = new Queries();
        
        $userId = get_current_user_id();
    
        $conn = connect();
        
        $results = $queries->gallosJoinGallosFotos($conn);
    
        if(count($results) < 1) {
            $thrownMessage = throwMessage('custom', 'No hay gallos para mostrar');
        }
    } catch (\Throwable $th) {
        var_dump($th);
    }	
?>

<html>
    <?php include 'customHeader.php'; ?>
<body>
    <style>
        <?php include 'customCss.css'; ?>
    </style>
    <?php include 'navigation.php'; ?>
    <?php include 'mensajes.php'; ?>
    <div class="gallos_botones_superiores">
        <h1>Mis gallos</h1>
        <a class="button" href="<?= $agregarGalloLink; ?>">Agregar nuevo</a>
    </div>

    <div class="mis_gallos_container">
        <?php if(count($results) > 0) {?>
            <?php foreach($results as $gallo){?>
                <div class="gallo_tarjeta">
                    <div class="mis_gallos_image">
                        <img src="<?= $gallo['nombre_foto'] ? $ONLINE_PATH.$gallo['nombre_foto'] : $ONLINE_PATH.'/no_image.jpg';?>"/>
                    </div>                    
                    <div class="mis_gallos_texto">
                        <p class="gallo_tarjeta_nombre">
                            <?= $gallo['nombre']; ?>
                        </p>
                        <a class="gallo_tarjeta_enlace" href="<?php echo goToUrl('mi-gallo/?gallo_id='.$gallo['id'].'')?>">ver más</a>
                    </div>
                </div>
            <?php }?>
        <?php }?>
    </div>
    
  </body>
</html>