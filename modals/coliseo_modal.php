
<div class="modal_background">
    <div class="modal_body">
        <div class="modal_title_area">
            <p class="modal_title">Guardar Coliseo</p>
            <p class="btn_cerrar" onclick='showModal("modal_background",false)'>X</p>
        </div>
        <div class="modal_content_body">
            <form method="post" enctype="multipart/form-data">
                <div class="modal_form_body">
                    <div class="modal_field">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" value="<?php if($nombre !== null){ echo $nombre; }?>" placeholder="Nombre" required />
                    </div>
                    <div class="modal_field">
                        <label for="nombre">Ciudad</label>
                        <input type="text" name="ciudad" value="<?php if($ciudad !== null){ echo $ciudad; }?>" placeholder="Ciudad" required />
                    </div>
                    <div class="modal_field">
                        <label for="color">Dirección</label>
                        <input type="text" name="direccion" value="<?php if($direccion !== null){ echo $direccion; }?>" placeholder="Dirección" required/>
                    </div>
                    <div class="modal_field">
                        <label for="pais">Pais</label>
                        <select name="pais">
                            <?php if($paisPreseleccionado){?>
                                <option value="<?= $paisPreseleccionado->getId()?>"><?= $paisPreseleccionado->getNombre(); ?></option>
                            <?php }?>
                            <?php foreach($paisesArr as $pais){?>
                                <option value="<?= $pais->getId()?>"><?= $pais->getNombre(); ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
                <div class="modal_footer" style="padding:20px;">
                    <input type="submit" class="button" value="Guardar"/>
                </div>
            </form>
        </div>
    </div>
</div>
