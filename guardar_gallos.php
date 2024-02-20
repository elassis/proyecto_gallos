<?php /* Custom Template Name: Guardar Gallo */?>

<?php
	include_once 'functions.php';
	include_once 'Classes/paises.php';
	include_once 'Classes/trabas.php';
	include_once 'Classes/gallos.php';
	include_once 'Classes/crestas.php';
	include_once 'Classes/queries.php';
	include_once 'Classes/coliseos.php';
	include_once 'Classes/codigos_coliseo.php';
    include_once 'local_folder.php';
   
	$conn = connect();

	$query = new queries();

	//GETTING USER
	$userId = get_current_user_id();
	$user = $query->select($conn, 'wp_users', 'ID', $userId);

	//GETTING PAISES
	$paises = $query->index($conn, 'paises');

	$paisesArr = [];

	if(count($paises) > 0){
		foreach($paises as $pais){
			$element = new Paises();
			$element->create($pais);
			array_push($paisesArr, $element);
		}
	}

		//GETTING PADRES
	$gallos = $query->index($conn, 'gallos');

	$padres = [];
	$madres = [];

	if(count($gallos) > 0){
		foreach($gallos as $gallo){
			$element = new Gallos();
			$element->create($gallo);
			if($element->getGenero() == 'macho'){
				$padres[] = $element;
			} else {
				$madres[] = $element;
			}
		}
	} 

	//GETTING CRESTAS
	$crestasArr = [];
	$crestas = $query->index($conn, 'crestas');

	if(count($crestas) > 0){
		foreach($crestas as $cresta){
			$element = new Crestas();
			$element->create($cresta);
			$crestasArr[] = $element;
		}
	}

	//GETTING TRABAS
	$trabasArr = [];
	$trabas = $query->index($conn, 'trabas');

	if(count($trabas) > 0){
		foreach($trabas as $traba){
			$element = new Trabas();
			$element->create($traba);
			$trabasArr[] = $element;
		}
	}

	//SAVE GALLO
    $validations = null;
	$thrownMessage = null;
    $paisPreseleccionado = null;
    $crestaPreseleccionada = null;
    $trabaPreseleccionada = null;
    $codigoColiseo = isset($_POST['codigo_coliseo']) ? htmlspecialchars($_POST['codigo_coliseo']) : null;
    $fechaNacimiento = isset($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : null;
    $codigoGallo = isset($_POST['codigo_gallo']) ? htmlspecialchars($_POST['codigo_gallo']) : null;
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : null;
    $color = isset($_POST['color']) ? htmlspecialchars($_POST['color']) : null;
    $peso = isset($_POST['peso']) ? htmlspecialchars($_POST['peso']) : null;
    $cresta = isset($_POST['cresta']) ? htmlspecialchars($_POST['cresta']) : null;
    $traba = isset($_POST['traba']) ? htmlspecialchars($_POST['traba']) : null;
    $pais = isset($_POST['pais']) ? htmlspecialchars($_POST['pais']) : null;
	 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //preserve the select values
        $crestaPreseleccionada = getModel($crestasArr, $cresta);
        $trabaPreseleccionada = getModel($trabasArr, $traba);
        $paisPreseleccionado = getModel($paisesArr, $pais);
        $requiredKeys = [
            'codigo_coliseo', 
            'codigo_gallo',
            'nombre', 
            'traba', 
            'cresta',
            'pais',
        ];
        $validations = emptyRequiredValues($_POST, $requiredKeys);

        if($validations[0] > 0){
            if(in_array('codigo_gallo', $validations[1]) && count($validations[1]) === 1){
                $thrownMessage = throwMessage('requiredSpecific', 'Código Gallo');
            }else{
                $thrownMessage = throwMessage('required');             
            }
        } else {
            $element = new Gallos();
            $element->create($_POST);            
            $saveGallo = $element->save($conn, 'gallos', $element->getElements());

            if($saveGallo !== true){
                if(strpos($saveGallo, 'codigo_gallo')){
                    $thrownMessage = throwMessage('duplicated', $codigoGallo);   
                }else if(strpos($saveGallo, 'codigo_coliseo')){
                    $thrownMessage = throwMessage('duplicated', $codigoColiseo); 
                }
            }else{                
                if($_FILES['foto_1']["name"]){
                    $galloId = $query->selectValues($conn, 'gallos', 'codigo_coliseo', ['id'], $codigoColiseo);

                    $photoName = savePhoto($_FILES['foto_1']["name"], $_FILES['foto_1']["tmp_name"], $LOCAL_FOLDER);
                    
                    if($photoName[0] !== true){
                        $thrownMessage = throwMessage('photoError', 'Foto 1'); 
                    }else {
                        //save name on table
                        $query->save($conn, 'fotos_gallos', $arr = [
                            'nombre_foto' => $photoName[1],
                            'numero_foto' => 'foto_1',
                            'gallo_id'    => $galloId[0]->id,
                        ]);

                    }
                   
                }

                if($_FILES['foto_2']["name"]){
                    $galloId = $query->selectValues($conn, 'gallos', 'codigo_coliseo', ['id'], $codigoColiseo);

                    $photoName = savePhoto($_FILES['foto_2']["name"], $_FILES['foto_2']["tmp_name"], $LOCAL_FOLDER);
                    
                    if($photoName[0] !== true){
                        $thrownMessage = throwMessage('photoError', 'Foto 2'); 
                        
                    }else {
                        //save name on table
                        $query->save($conn, 'fotos_gallos', $arr = [
                            'nombre_foto' => $photoName[1],
                            'numero_foto' => 'foto_2',
                            'gallo_id'    => $galloId[0]->id,
                        ]);

                    }
                }
                $thrownMessage = throwMessage('success', 'Gallo');
                $validations = null;
                $paisPreseleccionado = null;
                $crestaPreseleccionada = null;
                $fechaNacimiento = null;
                $trabaPreseleccionada = null;
                $codigoColiseo = null;
                $codigoGallo = null;
                $nombre = null;
                $color = null;
                $peso = null;
                $cresta = null;
                $traba = null;
                $pais = null;
            }

        }

    }  
        
?>

<html>
    <?php include 'customHeader.php'; ?>
		<body>
        <style>
            <?php include 'customCss.css'; ?>
        </style>
        <?php include 'navigation.php'; ?>
        <?php include 'mensajes.php'; ?>

			<form method="post" class="agregar_form" enctype="multipart/form-data">
                <p class="titulo">Agregar gallo</p>
                <div class="form-body">
                    <div class="row">
                        <div class="column">
                            <label for="codigo_gallo">codigo gallo</label>                           
                            <input placeholder="Código Gallo" type="text" name="codigo_gallo" class="select <?php if(!empty($validations) && in_array('pais', $validations[1]) && $pais == 'No') { echo 'error'; } ?>" value="<?php echo $codigoGallo;?>"/>
                        </div>
                        <div class="column">
                             <label for="codigo_coliseo">codigo coliseo</label>
                             <input placeholder="Código Coliseo" class="<?php if(strpos($messageToDisplay, 'código del coliseo')) { echo 'error'; }?>" type="text" name="codigo_coliseo" required value="<?php echo $codigoColiseo;?>"/>
                        </div>
                        <div class="column"> 
                            <label for="nombre">Nombre</label>         
                            <input placeholder="Nombre" type="text" name="nombre" required value="<?php if($nombre !== null){ echo $nombre; } else { echo '' ; };?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <label for="color">color</label> 
                            <input type="text" name="color" placeholder="Color" value="<?php echo $color;?>" />                           
                        </div>
                        <div class="column">
                            <label for="peso">peso</label>
                            <input type="number" placeholder="Peso" name="peso" step="0.1" value="<?php echo $peso;?>" />
                       </div>
                       <div class="column">
                            <label for="fecha_nacimiento">Fecha nac.</label>
                            <input type="date" name="fecha_nacimiento" value="<?php echo $fechaNacimiento; ?>"/>
                       </div> 
                    </div>
                    <div class="row">
                        <div class="column">
                        <label for="pais">pais</label>

                            <select name="pais" class="select <?php if(!empty($validations) && in_array('pais', $validations[1]) && $pais == 'No') { echo 'error'; } ?>" required>
                                    <?php if($paisPreseleccionado) { ?>
                                        <option value="<?= $paisPreseleccionado->getId();?>">
                                            <?= $paisPreseleccionado->getNombre();?>
                                        </option>
                                    <?php } else {?>
                                        <option value="No">Seleccione pais*</option>
                                    <?php } ?>
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
                        <label for="genero">genero</label>
                            <select name="genero">
                                <option value="macho">macho</option>
                                <option value="hembra">hembra</option>
                            </select>                            
                        </div>
                        <div class="column">
                            <label for="dueno">dueño</label>
                            <select name="dueno">
                                <option value="<?= $userId ?>"><?= $user[0]['display_name']?></option>
                            </select>                            
                        </div>
                    </div>
                    <div class="row">                    
                        <div class="column">
                            <label for="padre">padre</label>
                            <select name="padre">
                                <option value="0">Seleccione el padre</option>
                                    <?php if(count($padres) > 0) : ?>
                                        <?php foreach($padres as $padre) : ?>
                                            <option value="<?= $padre->getId();?>">
                                                <?= $padre->getNombre(); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                            </select>                        
                        </div>
                        <div class="column">
                            <label for="madre">madre</label>
                            <select name="madre">
                                <option value="0">Seleccione la madre</option>		
                                    <?php if(count($madres) > 0) : ?>
                                        <?php foreach($madres as $madre) : ?>
                                            <option value="<?= $madre->getId(); ?>">
                                                <?= $madre->getNombre(); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                            </select>                        
                        </div>
                        <div class="column">
                             <label for="cresta">cresta</label>
                                <select name="cresta" class="select <?php if(!empty($validations) && in_array('cresta', $validations[1]) && $cresta == 'No') { echo 'error'; } ?>" required>
                                    <?php if($crestaPreseleccionada) { ?>
                                        <option value="<?= $crestaPreseleccionada->getId();?>">
                                            <?= $crestaPreseleccionada->getNombre();?>
                                        </option>
                                    <?php } else {?>
                                        <option value="No">Seleccione cresta*</option>
                                    <?php } ?>
                                    <?php if(count($crestasArr) > 0) : ?>
                                        <?php foreach($crestasArr as $cresta) : ?>
                                            <option value="<?= $cresta->getId();?>">
                                                <?= $cresta->getNombre(); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                        </div>
                    </div>
                    <div class="row">                       
                       <div class="column">
                            <label for="traba">traba</label>
                            <select name="traba" class="select <?php if(!empty($validations) && in_array('traba', $validations[1]) && $traba == 'No') { echo 'error'; } ?>"  required>
                                    <?php if($trabaPreseleccionada) { ?>
                                        <option value="<?= $trabaPreseleccionada->getId();?>">
                                            <?= $trabaPreseleccionada->getNombre();?>
                                        </option>
                                    <?php } else {?>
                                        <option value="No">Seleccione traba*</option>
                                    <?php } ?>
                                    <?php if(count($trabasArr) > 0) : ?>
                                        <?php foreach($trabasArr as $traba) : ?>
                                            <option value="<?= $traba->getId();?>">
                                                <?= $traba->getNombre(); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                            </select>
                        </div>
                        <div class="column">
                            <label for="foto_1">foto 1</label>
                            <input type="file" name="foto_1" accept="image/*">
                        </div>
                        <div class="column">
                            <label for="foto_2">foto 2</label>
                            <input type="file" name="foto_2" accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <textarea type="text" class="text_area_form" name="observaciones" placeholder="observaciones"></textarea>
                    </div>
                </div>
                <div class="form_footer">
                    <input class="button" type="submit" value="Guardar"/>
                </div>
			</form>
		</body>  
</html>