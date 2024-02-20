<?php /* Custom Template Name: Mi gallo */?>
<?php
    include_once 'gallo_backend.php';
    include_once 'local_folder.php';
    
?>

<html>
    <?php include 'customHeader.php'; ?> 
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        <?php include 'customCss.css'; ?> 
    </style>
<body>
    <?php include 'navigation.php';?>
    <div class="banner_superior" style="background-image:url(<?= $ONLINE_PATH.$foto_1['nombre_foto'] ?? 
        $ONLINE_PATH.$foto_2['nombre_foto'] ?? $ONLINE_PATH.'/no_image.jpg' ?>); background-size:cover;">
        <div class="superficie">
            <p><?= $gallo->getNombre()?></p>
        </div>        
    </div>
    <div class="gallos_botones_superiores">
        <button class="button" style="padding:10px 10px" onclick='showModal("modal_background",true);'>Actualizar</button>
        <button class="button" style="padding:10px 10px" id="agregar_pelea">Agregar pelea</button>
        <button class="button" id="eliminar_gallo_button" style="padding:10px 10px" >Eliminar</button>
    </div>
    <?php include 'mensajes.php';?>
    <div class="contenedor">
        <div class="imagenes-section">
            <div class="portrait">
                <div id="foto_1" style="background-image:url(<?= $ONLINE_PATH.$foto_1['nombre_foto'] ?? $ONLINE_PATH.'/no_image.jpg' ?>"></div>
                <div id="foto_2" style="background-image:url(<?= $ONLINE_PATH.$foto_2['nombre_foto'] ?? $ONLINE_PATH.'/no_image.jpg' ?>"></div>
            </div>
            <div class="controls">
                <input type="submit" id="btn_1" onclick="showPhoto(this);" value="1"/>
                <input type="submit" id="btn_2" onclick="showPhoto(this);" value="2"/>
            </div>
        </div>
            <div class="data-section">
                <div>
                    <ul>
                        <li>
                            <input name="id" id="gallo_id" value="<?= $gallo->getId() ?? '' ?>" hidden />
                        </li>
                        <li>
                            <label for="nombre">codigo gallo</label>
                            <input name="codigo_gallo" value="<?= $gallo->getCodigo()?>" disabled />
                        </li>
                        <li>
                            <label for="nombre">nombre</label>
                            <input name="nombre" id="nombre" value="<?= $gallo->getNombre()?>" disabled />
                        </li>
                        <li>
                            <label for="color">color</label>
                            <input name="color" value="<?= $gallo->getColor()?>" disabled />
                        </li>
                    
                        <li>
                            <label for="pais">pais</label>
                            <input name="pais" value="<?= $gallo->getPais()?>" disabled />
                        </li>
                        <li>
                            <label for="genero">genero</label>
                            <input name="genero" value="<?= $gallo->getGenero()?>" disabled />
                        </li>
                   
                        <li>
                            <label for="fecha_de_nacimiento">fecha de nacimiento</label>
                            <input name="fecha_de_nacimiento" value="<?= $gallo->getFechaNacimiento()?>" disabled />
                        </li>
                        <li>
                            <label for="peso">peso</label>
                            <input name="peso" type="number" value="<?= $gallo->getPeso()?>" disabled />
                        </li>
                   
                        <li>
                            <label for="cresta">cresta</label>
                            <input name="cresta" value="<?= $gallo->getCresta()?>" disabled />
                        </li>
                        <li>
                            <label for="traba">traba</label>
                            <input name="traba" value="<?= $gallo->getTraba()?>" disabled />
                        </li>
                   
                        <li>
                            <label for="cresta">observ.</label>
                            <?php if($gallo->getObservaciones() == '') : ?>
                                <input name="observaciones" value="N/A" disabled/>
                            <?php else : ?>
                                <input name="observaciones" value="<?= $gallo->getObservaciones() ?>" disabled/>
                            <?php endif;?>       
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="peleas-section">
            <h3>Peleas</h3>
            <div>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Coliseo</th>
                        <th>Contrincante</th>
                        <th>Resultado</th>
                        <th>Observaciones</th>
                        <th>Tiempo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach($arrayPeleas as $pelea):?>
                        <tr>
                            <td><?= $pelea->getId() ?></td>
                            <td><?= $pelea->getFecha() ?></td>
                            <td><?= $pelea->getColiseo() ?></td>
                            <td><?= $pelea->getContrincante() ?></td>
                            <td><?= $pelea->getResultado() ?></td>
                            <?php if($pelea->getObservaciones() == '') : ?>
                                <td>N/A</td>
                            <?php else : ?>
                                <td><?= $pelea->getObservaciones() ?></td>
                            <?php endif;?> 
                            <td>
                                <?= $pelea->getMinutos() ?> minutos 
                                <?= $pelea->getSegundos()?> segundos
                            </td>
                            <td>
                                <button type="submit" class="editar_pelea" value="<?= $pelea->getId()?>">Editar</button>
                                <button type="submit" class="eliminar_pelea" value="<?= $pelea->getId()?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>

    <?php include 'modals/gallo_modal.php';?>
    <?php include 'peleas_modal.php';?>
    <?php include 'modals/validate_delete_modal.php';?>
 

    <script>
        function showModal(modalName = null, value = false){
            if(value === true){
                document.querySelector(`.${modalName}`).style.display="flex";
            }else{
                document.querySelector(`.${modalName}`).style.display="none";
            }
        }

        showModal('modal_background', false);
        showModal('modal_validate', false);
        showModal('modal_pelea', false);


        var elementToHide = document.getElementById('foto_2');
        // Set the display property to 'none'
        elementToHide.style.display = 'none';

        document.getElementById('btn_1').style.backgroundColor = 'black';
        document.getElementById('btn_1').style.color = 'white';
        
        function showPhoto(e){
            if(e.value == 1){
                e.style.backgroundColor = 'black';
                e.style.color = 'white';
                document.getElementById('btn_2').style.backgroundColor = 'transparent';
                document.getElementById('btn_2').style.color = 'black';

                document.getElementById('foto_2').style.display = 'none';
                document.getElementById('foto_1').style.display = 'block';
            }else if(e.value == 2){
                e.style.backgroundColor = 'black';
                e.style.color = 'white';
                document.getElementById('btn_1').style.backgroundColor = 'transparent';
                document.getElementById('btn_1').style.color = 'black';

                document.getElementById('foto_2').style.display = 'block';
                document.getElementById('foto_1').style.display = 'none';
            }
        }
        
        let idGallo = document.querySelector('#gallo_id').value;

        $(document).ready(function () {
            $("#agregar_pelea").click(function () {              
                document.querySelector('#gallo_id_modal').value = idGallo;
                document.querySelector('#pelea_id_modal').value = null;
                document.querySelector('#contrincante').value = null;
                document.querySelector('#fecha').value = null;
                document.querySelector('#minutos').value = null;
                document.querySelector('#segundos').value = null;
                document.querySelector('#observaciones').value = null;
                document.querySelector('#empty').innerHTML = 'Seleccione coliseo';
                document.querySelector('#empty').value = 'no';
                document.querySelector('#empty_resultado').value = 'N/A';
                document.querySelector('#empty_resultado').innerHTML = 'Seleccione resultado';
                let submitButton = document.getElementsByName('submit_pelea');
                submitButton[0].value = 'Guardar';               
                
                showModal('modal_pelea', true);
            
            });

             $(".editar_pelea").click(function () {              
                const data = {
                    pelea_id: this.value,
                };
                $.ajax({
                    type: "POST",
                    data,
                    success: (response) => {
                         if(response.status == 200){
                            let submitButton = document.getElementsByName('submit_pelea');
                            submitButton[0].value = 'Actualizar Pelea';
                            const data = response.payload;
                            document.querySelector('#pelea_id_modal').value = data.id;
                            document.querySelector('#gallo_id_modal').value = data.gallo;
                            document.querySelector('#contrincante').value = data.contrincante;
                            document.querySelector('#fecha').value = data.fecha;
                            document.querySelector('#minutos').value = data.minutos;
                            document.querySelector('#segundos').value = data.segundos;
                            document.querySelector('#observaciones').value = data.observaciones;
                            document.querySelector('#empty').innerHTML = data.coliseo[0];
                            document.querySelector('#empty').value = data.coliseo[1];
                            document.querySelector('#empty_resultado').value = data.resultado[1];
                            document.querySelector('#empty_resultado').innerHTML = data.resultado[0];
                            
                            showModal('modal_pelea', true);
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    }
                })
            });

            $("#eliminar_gallo_button").click(function () { 
                document.querySelector('#delete_key').value = document.querySelector("#nombre").value;
                showModal('modal_validate',true);
            });

            $(".eliminar_pelea").click(function () {               
               const data = {
                   pelea_eliminar_id: this.value,
               };
               $.ajax({
                   type: "POST",
                   data,
                   success: (response) => {
                        if(response.status == 200){
                            window.location.reload();
                        }
                   }
               })
           });
        });
    </script>
</body>
</html>