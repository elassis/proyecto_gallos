<div class="modal_background" style="display:none;">
    <div class="modal_body" style="height:fit-content">
        <div class="modal_title_area">
            <p class="modal_title">
                <?= $modal_title; ?>
            </p>
            <p class="btn_cerrar" onclick='showModal("modal_background",false)'>X</p>
        </div>
        <div class="modal_content_body">
            <form method="post" enctype="multipart/form-data">
                <div class="modal_form_body" style="min-height:fit-content;padding:20px 0;">
                    <div class="modal_field">
                        <input type="text" id="modal_id" name="traba_id" hidden/>
                    </div> 
                    <div class="modal_field">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="modal_nombre" name="nombre" placeholder="Nombre" required />
                    </div>
                    <div class="modal_field">
                        <label for="nombre">Pais</label>
                        <select name="pais" class="select <?php if(!empty($validations) && in_array('pais', $validations[1]) && $pais == 'No') { echo 'error'; } ?>" required>
                            <option value="No" id="default_option">Seleccione pais*</option>
                            <?php if(count($paisesArr) > 0) : ?>
                                <?php foreach($paisesArr as $pais) : ?>
                                    <option value="<?= $pais->getId();?>">
                                        <?= $pais->getNombre(); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div> 
                    <div class="modal_field">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="modal_ciudad" name="ciudad" placeholder="Ciudad" required />
                    </div>                  
                </div>
                <div class="modal_footer" style="padding:20px;">
                    <input type="submit" id="modal_trabas" name="modal_trabas" class="button" value="Guardar"/>
                </div>
            </form>
        </div>
    </div>
</div>