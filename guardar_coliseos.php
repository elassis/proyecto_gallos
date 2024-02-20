<?php /* Custom Template Name: Guardar Coliseo */?>

<?php
	include_once 'functions.php';
	include_once 'Classes/paises.php';
	include_once 'Classes/queries.php';
    include_once 'Classes/coliseos.php';
    include_once 'local_folder.php';

	
    
	$conn = connect();
    
	$query = new queries();
    
    $thrownMessage = null;
    $deleteText = 'Esta seguro que desea Eliminar este Coliseo?';
    $deleteTitle = 'Eliminar Coliseo';
    $coliseoToDelete = null;

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

    //GETTING COLISEOS
    $coliseos = $query->index($conn, 'coliseos');

    $coliseosArr = [];

    if(count($coliseos) > 0){
        foreach($coliseos as $coliseo){
            $element = new Coliseos();
            $element->create($coliseo);
            array_push($coliseosArr, $element);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && 
        isset($_POST['nombre_coliseo']) && 
        !isset($_POST['pais']))
    {
        $coliseoModal = (count($coliseosArr)) ? findInArrayObjects($_POST['nombre_coliseo'], $coliseosArr, 'nombre') : null;
        $coliseoValues = array_values($coliseoModal);

        //find the country info
        $paisModal = findInArrayObjects($coliseoValues[0]->getPais(), $paisesArr, 'id');
        $paisValues = array_values($paisModal);
       
        $responseData = array(
            "id"          => $coliseoValues[0]->getId(),
            "nombre"      => $coliseoValues[0]->getNombre(),
            "ciudad"      => $coliseoValues[0]->getCiudad(),
            "direccion"   => $coliseoValues[0]->getDireccion(),
            "pais_nombre" => $paisValues[0]->getNombre(),
            "pais_id"     => $paisValues[0]->getId(), 
        );
        // Send the JSON response
        header('Content-Type: application/json');
        echo json_encode($responseData);
        exit();
    }

    //DELETE ACTION
    if($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['delete_button'])){
        $coliseoToDelete = $_POST['delete_key'];
                
        $deleteColiseo = $query->delete(
            $conn, 
            'coliseos', 
            "nombre = '$coliseoToDelete'",
        );

        if($deleteColiseo !== true){
            if(strpos($deleteColiseo->getMessage(), 'peleas_coliseo_id')){
                $thrownMessage = throwMessage('custom', 'No se puede eliminar un coliseo con peleas registradas, si desea eliminar este coliseo, debe eliminar las peleas primero.');
            }else{
                $thrownMessage = throwMessage('custom', 'Hubo un error al borrar el coliseo');
            }
        }else{
            header('Location: '.$_SERVER['PHP_SELF'].'/coliseos');
        }
    }

    // UPDATE ACTION
    if($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['id'])){
        
        $requiredKeys = [
            'id',
            'nombre', 
            'pais',
            'ciudad',
            'direccion', 
        ];
        $validations = emptyRequiredValues($_POST, $requiredKeys);
        
        if($validations[0] > 0){
            $thrownMessage = throwMessage('required');             
        } else {
            $element = new Coliseos();
            $element->create($_POST);
            $id = $element->getId();
            $result = $element->update($conn, 'coliseos', $element->getElements(), "id = $id");
          
            if($result !== true){
                $thrownMessage = throwMessage('required');
            }else{
                header('Location: '.$_SERVER['PHP_SELF'].'/coliseos');
                $thrownMessage = throwMessage('success', 'Coliseo');                
            }
        }
    }


    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : null;
    $ciudad = isset($_POST['ciudad']) ? htmlspecialchars($_POST['ciudad']) : null;
    $direccion = isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : null;
    $pais = isset($_POST['pais']) ? htmlspecialchars($_POST['pais']) : null;
    $paisPreseleccionado = null;

    //SAVE COLISEO
	$message = null;
	if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nombre'])){
        $paisPreseleccionado = getModel($paisesArr, $pais);
        $requiredKeys = [
            'nombre', 
            'pais',
            'ciudad',
            'direccion', 
        ];
        $validations = emptyRequiredValues($_POST, $requiredKeys);
        if($validations[0] > 0){
            $thrownMessage = throwMessage('required');             
        } else {
            $element = new Coliseos();
            $element->create($_POST);
            $result = $element->save($conn, 'coliseos', $element->getElements());
            
            if($result !== true){
                if(strpos($result, 'nombre')){
                    $thrownMessage = throwMessage('duplicated', $nombre);   
                }else if(strpos($result, 'direccion')){
                    $thrownMessage = throwMessage('duplicated', $direccion);   
                }
            }else{ 
                $nombre = null;
                $ciudad = null;           
                $direccion = null;
                $pais = null;
                $paisPreseleccionado = null;
                header('Location: '.$_SERVER['PHP_SELF'].'/coliseos');
            }
        }
	} 
    
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Enmanuel Lassis">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	</head>
		<body>
			<style>
				<?php include 'customCss.css'; ?>
			</style>
            <?php include 'navigation.php'; ?>
            <?php include 'mensajes.php'; ?>

            <button onclick="showModal('modal_background', true);" class="button agregar_button">Agregar Coliseo</button>
            
            <div class="mis_gallos_container">
                <?php if(count($coliseosArr) > 0) {?>
                    <?php foreach($coliseosArr as $coliseo){?>
                        <div class="gallo_tarjeta">
                            <div class="mis_gallos_image">
                                <p class="titulo_entidades"><?= $coliseo->getNombre(); ?></p>
                            </div>
                            <div class="mis_gallos_texto">
                                <button id="<?= $coliseo->getNombre(); ?>" class="gallo_tarjeta_enlace nombre_coliseo">editar</button>
                                <button id="<?= $coliseo->getNombre(); ?>" class="gallo_tarjeta_enlace delete_coliseo">eliminar</button>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>
            </div>

        <?php include 'modals/coliseo_modal.php'; ?>
        <?php include 'modals/coliseo_modificar_modal.php'; ?>
        <?php include 'modals/validate_delete_modal.php';?>

        
        <script>
            displayDropdown();
            showModal('modal_validate', false);
            showModal('modal_background', false);
            showModal('coliseo_modificar', false);

            function displayDropdown(id = null){
                let dropdowns = document.querySelectorAll('.gallo_acciones_dd');
                if(!id){
                    dropdowns.forEach(function(element) {
                        element.style.display="none";
                    });
                }else{
                    let dropdownToDisplay = document.querySelector(`#${id}`);
                    if(dropdownToDisplay.style.display === "block"){
                        dropdownToDisplay.style.display="none";
                    }else{
                        dropdownToDisplay.style.display="block";
                    }
                }
            }

            
            function showModal(modalName = null, value = false){
                if(value === true){
                    document.querySelector(`.${modalName}`).style.display="flex";
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }else{
                    document.querySelector(`.${modalName}`).style.display="none";
                }
            };

            
            $(document).ready(function () {
                // Event handler for the button click
                $(".nombre_coliseo").click(function () {
                    // Get the data to send (you can customize this part based on your needs)
                    var data = {
                        nombre_coliseo: this.id,
                    }                   
                    
                    // Send the POST request using jQuery's ajax() method
                   $.ajax({
                        type: "POST",
                        data: data,
                        success: function (response) {
                            document.querySelector('#modal_id').value = response.id; 
                            document.querySelector('#modal_nombre').value = response.nombre; 
                            document.querySelector('#modal_ciudad').value = response.ciudad;
                            document.querySelector('#modal_direccion').value = response.direccion;
                            //pais
                            let modalOption = document.querySelector('#modal_option');
                            modalOption.value = response.pais_id;
                            modalOption.innerHTML = response.pais_nombre;
                            showModal('coliseo_modificar',true);
                            
                        }
                    });
                });
             });

             $(document).ready(function () {
                // Event handler for the button click
                $(".delete_coliseo").click(function () {
                    showModal('modal_validate', true);
                    let deleteInput = document.querySelector('#delete_key');
                    deleteInput.value = this.id;
                    deleteInput.innerHTML = this.id;
                });
             });
        </script>
		</body>  
</html>