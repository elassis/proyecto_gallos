<?php /* Custom Template Name: Guardar Traba */?>

<?php include_once 'trabas_backend.php'; ?>

<html>
    <?php include_once 'customHeader.php';?>
    <body>
        <style>
            <?php include 'customCss.css'; ?>
        </style>
        <?php include 'navigation.php'; ?>
        <?php include 'mensajes.php'; ?>

        <button id="agregar_traba" class="button agregar_button">Agregar Traba</button>
        <div id="hidden_form_container" style="display:none;">
            <p class="titulo">Agregar Traba</p>    
            <form method="post" class="agregar_form">
                <div class="form-body agregar_body_form">
                    <div class="row custom_row">
                        <div class="column">
                            <label for="nombre">Nombre Traba</label>
                            <input type="text" placeholder="Nombre" name="nombre" value="<?php if($nombre !== null){ echo $nombre;}?>" required />
                        </div>
                        <div class="column">
                            <label for="pais">Pais</label>
                            <select name="pais" class="select <?php if(!empty($validations) && in_array('pais', $validations[1]) && $pais == 'No') { echo 'error'; } ?>" required>
                                <?php if($paisPreseleccionado) { ?>
                                    <option value="<?= $paisPreseleccionado->getId();?>">
                                        <?= $paisPreseleccionado->getNombre();?>
                                    </option>
                                <?php } else {?>
                                    <option value="No">Seleccione pais*</option>
                                <?php }?>
                                <?php if(count($paisesArr) > 0) : ?>
                                    <?php foreach($paisesArr as $pais) : ?>
                                        <option value="<?= $pais->getId();?>">
                                            <?= $pais->getNombre(); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="column">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" placeholder="Ciudad" name="ciudad" value="<?php if($ciudad !== null){ echo $ciudad;}?>" required />
                        </div>
                    </div>
                </div>
                <div class="form_footer">
                    <input class="button" type="submit" value="Guardar"/>
                </div>
            </form>
        </div>
        <div class="mis_gallos_container">
            <?php if(count($trabasArr) > 0) :?>
                <?php foreach($trabasArr as $traba):?>
                    <div class="gallo_tarjeta">
                        <div class="mis_gallos_image">
                            <p class="titulo_entidades"><?= $traba->getNombre();?></p>
                        </div>
                        <div class="mis_gallos_texto">
                            <button id="<?= $traba->getId();?>" class="gallo_tarjeta_enlace btn_editar">editar</button>
                            <button id="<?= $traba->getNombre();?>" class="gallo_tarjeta_enlace btn_eliminar">eliminar</button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <?php include 'trabas_modal.php'; ?>
        <?php include 'modals/validate_delete_modal.php'; ?>
        <?php include_once 'trabas_scripts.php'; ?>
    </body>  
</html>