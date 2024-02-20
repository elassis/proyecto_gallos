<?php /* Custom Template Name: Guardar Cresta */?>

<?php include_once 'crestas_backend.php';?>

<html>  
<?php include_once 'customHeader.php';?>
    <body>
        <style>
            <?php include 'customCss.css'; ?>
        </style>
        <?php include 'navigation.php'; ?>
        <?php include 'mensajes.php'; ?>
        <button id="agregar_cresta" class="button agregar_button">Agregar Cresta</button>
        <div id="hidden_form_container" style="display:none;">
            <form method="post" class="agregar_form">
                <p class="titulo">Agregar cresta</p>
                <div class="form-body agregar_body_form">
                    <div class="row custom_row">
                        <div class="column">
                            <label for="nombre">Nombre Cresta</label>
                            <input type="text" name="nombre" value="<?php if($nombre !== null){ echo $nombre; }?>" placeholder="Nombre" required />
                        </div>
                    </div>
                </div>
                <div class="form_footer">
                    <input class="button" type="submit" value="Guardar"/>
                </div>
            </form>
        </div>
            <div class="mis_gallos_container">
            <?php if(count($crestasArr) > 0) :?>
                <?php foreach($crestasArr as $cresta):?>
                    <div class="gallo_tarjeta">
                        <div class="mis_gallos_image">
                            <p class="titulo_entidades"><?= $cresta->getNombre();?></p>
                        </div>
                        <div class="mis_gallos_texto">
                            <button id="<?= $cresta->getId();?>" class="gallo_tarjeta_enlace btn_editar">editar</button>
                            <button id="<?= $cresta->getNombre();?>" class="gallo_tarjeta_enlace btn_eliminar">eliminar</button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>

        <?php include 'crestas_modal.php'; ?>
        <?php include 'modals/validate_delete_modal.php'; ?>

        <?php include_once 'crestas_scripts.php'; ?>

    </body>  
</html>