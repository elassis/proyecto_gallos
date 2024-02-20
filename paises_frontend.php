<?php /* Custom Template Name: Guardar Pais */?>

<?php include_once 'paises_backend.php'; ?>

<html>
   <?php include_once 'customHeader.php';?>
    <body>
        <style>
            <?php include 'customCss.css'; ?>
        </style>
        <?php include 'navigation.php'; ?>
        <?php include 'mensajes.php'; ?>

        <button id="agregar_pais" class="button agregar_button">Agregar Pais</button>
        <div id="hidden_form_container" style="display:none;">
            <p class="titulo">Agregar Pais</p>
            <form method="post" class="agregar_form">
                <div class="form-body agregar_body_form">
                    <div class="row custom_row">
                        <div class="column">
                            <label for="nombre">Nombre Pais</label>
                            <input type="text" name="nombre" placeholder="Nombre pais" value="<?php echo $nombre; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form_footer">
                    <input class="button" type="submit" value="Guardar"/>
                </div>
            </form>
        </div>
        <div class="mis_gallos_container">
            <?php if(count($paisesArr) > 0) :?>
                <?php foreach($paisesArr as $pais):?>
                    <div class="gallo_tarjeta">
                        <div class="mis_gallos_image">
                            <p class="titulo_entidades"><?= $pais->getNombre();?></p>
                        </div>
                        <div class="mis_gallos_texto">
                            <button id="<?= $pais->getId();?>" class="gallo_tarjeta_enlace btn_editar">editar</button>
                            <button id="<?= $pais->getNombre();?>" class="gallo_tarjeta_enlace btn_eliminar">eliminar</button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>

        <?php include 'paises_modal.php'; ?>
        <?php include 'modals/validate_delete_modal.php'; ?>
        <?php include_once 'paises_scripts.php'; ?>
    </body>  
</html>