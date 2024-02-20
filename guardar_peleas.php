<?php /* Custom Template Name: Guardar Pelea */?>

<?php
    include_once 'peleas_backend.php';
?>

<html>
	<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta name="author" content="Enmanuel Lassis">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	</head>
		<body>
			<style>
				<?php include 'customCss.css';?>
			</style>
            <?php include 'navigation.php'; ?>
		    <?php include 'mensajes.php'; ?>

			<form method="post" class="gallos_form">
                <p class="titulo">Agregar Pelea</p>	
                <div class="form-body">                
                    <div class="row">
                        <div class="column">
                            <select name="coliseo" class="select <?php if(!empty($validations) && in_array('coliseo', $validations[1]) && $coliseo == 'No') { echo 'error'; } ?>" required>
                                <?php if($coliseoPreseleccionado) { ?>
                                    <option value="<?= $coliseoPreseleccionado->getId();?>">
                                        <?= $coliseoPreseleccionado->getNombre();?>
                                    </option>
                                    <?php } else {?>
                                <option value="No">Seleccione coliseo</option>
                                <?php }?>
                                <?php if(count($coliseosArr) > 0) : ?>
                                    <?php foreach($coliseosArr as $coliseo) : ?>
                                        <option value="<?= $coliseo->getId();?>">
                                            <?= $coliseo->getNombre(); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <a href="wordpress/guardar-coliseo">Agregar coliseo</a>
                        </div>
                        <div class="column">
                            <select name="gallo" class="<?php if(!empty($validations) && in_array('gallo', $validations[1]) && $gallo == 'No') { echo 'error'; } ?>" required>
                            <?php if($galloPreseleccionado) { ?>
                                        <option value="<?= $galloPreseleccionado->getId();?>">
                                            <?= $galloPreseleccionado->getNombre();?>
                                        </option>
                                    <?php } else {?>
                                <option value="No">Seleccione gallo</option>
                                <?php }?>
                                    <?php if(count($userGallosArr) > 0) : ?>
                                        <?php foreach($userGallosArr as $gallo) : ?>
                                            <option value="<?= $gallo->getId();?>">
                                                <?= $gallo->getNombre(); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                            </select>
                            <a href="wordpress/guardar-gallo">Agregar gallo</a>
                        </div>
                        <div class="column">
                            <label for="fecha">fecha</label>
                            <input type="date" name="fecha"  value="<?php echo $fecha; ?>" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column" style="min-width:300px">
                            <input type="text" placeholder="Nombre/código del gallo contrincante" name="contrincante"  value="<?php echo $contrincante; ?>" required/>
                        </div>
                        <div style="min-width:180px" class="column">
                            <select name="resultado" class="<?php if(!empty($validations) && $resultado == 'N/A') { echo 'error'; } ?>" required>
                            <?php if($resultado && $resultado !== 'N/A') { ?>
                                        <option value="<?= $resultado;?>">
                                            <?php 
                                            $resultadoObj = [
                                                'g'=> 'ganador',
                                                'p'=> 'perdedor',
                                                't'=> 'tabla', 
                                            ];
                                            echo $resultadoObj[$resultado];?>
                                        </option>
                                    <?php } else {?>
                                <option value="N/A">Seleccione resultado</option>
                                <?php }?>
                                <option value="g">ganador</option>
                                <option value="p">perdedor</option>  
                                <option value="t">tabla</option>  
                            </select>
                        </div>                        
                    </div>		                    
                    <fieldset>
                        <legend>Tiempo de pelea</legend>
                        <input type="number" placeholder="Minutos" name="minutos"  value="<?php echo $minutos; ?>" required>
                        <input type="number"  placeholder="segundos" name="segundos"  value="<?php echo $segundos; ?>" required>
                    </fieldset>
                    <textarea name="observaciones" placeholder="observaciones"></textarea>
                </div>		
			<input type="submit" class="button" value="Guardar"/>
	    </form>
	</body>  
</html>