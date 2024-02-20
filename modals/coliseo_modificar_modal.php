<div class="modal_background coliseo_modificar">
    <div class="modal_body" style="height:fit-content;">
        <div class="modal_title_area">
            <p class="modal_title">
                Modificar Coliseo
            </p>
            <p class="btn_cerrar" onclick='showModal("coliseo_modificar",false)'>X</p>
        </div>
        <div class="modal_content_body" style="height:fit-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal_form_body" style="min-height:260px;padding:20px 0;">
                    <div class="modal_field">
                        <label for="nombre">id</label>
                        <input type="text" id="modal_id" name="id"  placeholder="id" hidden required />
                    </div>    
                    <div class="modal_field">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="modal_nombre" name="nombre"  placeholder="Nombre" required />
                    </div>
                    <div class="modal_field">
                        <label for="nombre">Ciudad</label>
                        <input type="text" id="modal_ciudad" name="ciudad" placeholder="Ciudad" required />
                    </div>
                    <div class="modal_field">
                        <label for="color">Dirección</label>
                        <input type="text" id="modal_direccion" name="direccion" placeholder="Dirección" required/>
                    </div>
                    <div class="modal_field">
                        <label for="pais">Pais</label>
                        <select name="pais" id="modal_pais">                          
                            <option value="" id="modal_option"></option>
                            <?php foreach($paisesArr as $pais){?>
                                <option value="<?= $pais->getId()?>"><?= $pais->getNombre(); ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="modal_footer" style="padding:20px;">
                    <input type="submit" class="button" value="Actualizar"/>
                </div>
            </form>
        </div>
    </div>
</div>