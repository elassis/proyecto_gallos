<?php
    require_once 'peleas_backend.php';
?>

        <div class="modal_background modal_pelea">
            <div class="modal_body">
                <div class="modal_title_area">
                    <p class="modal_title">
                        Agregar Pelea
                    </p>
                    <p class="btn_cerrar" onclick='showModal("modal_pelea",false)'>X</p>
                </div>
                <div class="modal_content_body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal_form_body">
                            <div class="modal_field">
                                <?= component('input', '', 'pelea_id', '', 'pelea_id_modal', '', '', '', 'hidden') ?>                      
                            </div> 
                            <div class="modal_field">
                                <?= component('input', '', 'gallo', '', 'gallo_id_modal', '', '', '', 'hidden') ?>                      
                            </div> 
                            <div class="modal_field">
                                <label for="contrincante">info. contrincante</label>
                                <input name="contrincante" id="contrincante" value="<?= $contrincante ?>" placeholder="Info. del contrincante" required />
                            </div> 
                            <div class="modal_field">
                                <label for="fecha">Fecha pelea</label>
                                <?= component('input','date', 'fecha', '', 'fecha', $fecha, '', '', 'required'); ?>
                            </div> 
                            <div class="modal_field">
                                <label for="fecha">Coliseo</label>
                                <select name="coliseo" id="coliseo" class="select <?php if(!empty($validations) && in_array('coliseo', $validations[1]) && $coliseo == 'No') { echo 'error'; } ?>" required>
                                    <?php if(!empty($coliseoPreseleccionado)) :?>
                                            <?= component('option', '', '', '', '', $coliseoPreseleccionado->getId(), '', $coliseoPreseleccionado->getNombre(), '')?>
                                    <?php else:?>
                                            <?= component('option', '', '', '', 'empty', 'No', '', 'Seleccione coliseo', '')?>
                                    <?php endif;?>
                                    <?php if(count($coliseosArr) > 0) : ?>
                                        <?php foreach($coliseosArr as $coliseo) : ?>
                                            <?= component('option', '', '', '', '', $coliseo->getId(), '',$coliseo->getNombre(), '')?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>                    
                            <div class="modal_field">
                                <label for="fecha">Resultado</label>
                                <select name="resultado" id="resultado" class="<?php if(!empty($validations) && $resultado == 'N/A') { echo 'error'; } ?>" required>
                                    <?php if(!empty($resultado) && $resultado !== 'N/A') :?>
                                        <?= component('option', '', '', '', '', $resultado, '', $resultadosArr[$resultado], '')?>
                                    <?php else:?>
                                        <?= component('option', '', '', '', 'empty_resultado', 'N/A', '', 'Seleccione resultado', ''); ?>
                                    <?php endif;?>
                                    <?= component('option', '', '', '', '', 'g', '', 'ganador', ''); ?>
                                    <?= component('option', '', '', '', '', 'p', '', 'perdedor', ''); ?>
                                    <?= component('option', '', '', '', '', 't', '', 'tabla', ''); ?>                                    
                                </select>
                            </div>
                            <fieldset>
                                <legend>Tiempo de pelea</legend>
                                <div class="modal_field">
                                    <?= component('input', 'number', 'minutos', '', 'minutos', $minutos, 'minutos', '', 'required'); ?> 
                                </div>
                                <div class="modal_field">
                                    <?= component('input', 'number', 'segundos', '', 'segundos', $segundos, 'segundos', '', 'required'); ?>
                                </div>           
                            </fieldset> 
                            
                            <div class="modal_field">
                                <label for="fecha">Observ.</label>
                                <?= component('textarea', '', 'observaciones', '', 'observaciones', '', 'observaciones', '', ''); ?>
                            </div>                
                        </div>
                        <div class="modal_footer">		
                            <input type="submit" id="submit_pelea" name="submit_pelea" class="button" value="Guardar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
