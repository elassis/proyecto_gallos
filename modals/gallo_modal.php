
<div class="modal_background">
    <div class="modal_body">
        <div class="modal_title_area">
            <p class="modal_title">
                Actualizar Gallo
            </p>
            <p class="btn_cerrar" onclick='showModal("modal_background",false)'>X</p>
        </div>
        <div class="modal_content_body">
            <form method="post" enctype="multipart/form-data">
                <div class="modal_form_body">
                    <div class="modal_field">
                        <label for="codigo_gallo">Código gallo</label>
                        <input name="codigo_gallo" value="<?= $gallo->getCodigo()?>"/>
                    </div>
                    <div class="modal_field">
                        <label for="nombre">Nombre</label>
                        <input name="nombre" value="<?= $gallo->getNombre()?>"/>
                    </div>
                    <div class="modal_field">
                        <label for="color">Color</label>
                        <input name="color" value="<?= $gallo->getColor()?>"/>
                    </div>
                    <div class="modal_field">
                        <label for="pais">Pais</label>
                        <select name="pais">
                            <option value="<?= $paisPreseleccionado->getId()?>"><?= $paisPreseleccionado->getNombre(); ?></option>
                            <?php foreach($paisesArr as $pais){?>
                                <option value="<?= $pais->getId()?>"><?= $pais->getNombre(); ?></option>
                                <?php }?>
                            </select>
                    </div>
                    <div class="modal_field">
                            <label for="genero">Genero</label>
                            <select name="genero">
                                <option value="<?= $gallo->getGenero()?>"><?= $gallo->getGenero(); ?></option>
                                <option value="macho">macho</option>
                                <option value="hembra">hembra</option>
                            </select>
                    </div>                       
                    <div class="modal_field">
                        <label for="fecha_nacimiento">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" value="<?= $gallo->getFechaNacimiento()?>"/>
                    </div>
                    <div class="modal_field">
                        <label for="peso">Peso</label>
                        <input name="peso" type="number" step="0.1" value="<?= $gallo->getPeso() ?>"/>
                    </div>
                  
                     <div class="modal_field">
                        <label for="foto_1">foto 1 (<?= $foto_1 !== null ? $foto_1['nombre_foto'] : 'N/A';?>)</label>
                        <input type="file" name="foto_1" accept="image/*">
                    </div>
                    <div class="modal_field">
                        <label for="foto_2">foto 2 (<?= $foto_2 !== null ? $foto_2['nombre_foto'] : 'N/A'; ?>)
                        </label>
                        <input type="file" name="foto_2" accept="image/*">
                    </div>
                    <div class="modal_field">
                        <label for="cresta">Cresta</label>
                        <select name="cresta">
                            <option value="<?= $crestaPreseleccionado->getId()?>"><?= $crestaPreseleccionado->getNombre(); ?></option>
                            <?php foreach($crestasArr as $cresta){?>
                                <option value="<?= $cresta->getId()?>"><?= $cresta->getNombre(); ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="modal_field">
                        <label for="traba">Traba</label>
                        <select name="traba">
                            <option value="<?= $trabaPreseleccionado->getId()?>"><?= $trabaPreseleccionado->getNombre(); ?></option>
                            <?php foreach($trabasArr as $traba){?>
                                <option value="<?= $traba->getId()?>"><?= $traba->getNombre(); ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="modal_field">
                        <label for="codigo_coliseo">Código coliseo</label>
                        <input name="codigo_coliseo" value="<?= $gallo->getCodigoColiseo() ?>"/>
                    </div>
                    <div class="modal_field">
                            <label for="observaciones">Observ.</label>
                            <textarea name="observaciones" value="<?= $gallo->getObservaciones()?>"></textarea>
                    </div>
                </div>
                <div class="modal_footer">
                    <input type="submit" class="button" name="actualizar" value="Actualizar"/>
                </div>
            </form>
        </div>
    </div>
</div>
