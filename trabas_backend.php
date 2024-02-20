<?php
	include_once 'functions.php';
	include_once 'Classes/trabas.php';
	include_once 'Classes/paises.php';
	include_once 'Classes/queries.php';

	$conn = connect();

	$query = new Queries();
    $modal_title = 'Editar traba';
    $deleteTitle = 'Eliminar Traba';
    $deleteText = 'Esta seguro desea eliminar esta traba?';
    $thrownMessage = null;

	// GETTING PAISES //
	$paises = $query->index($conn, 'paises');
	$paisesArr = [];

	if(count($paises) > 0){
		foreach($paises as $pais){
			$element = new Paises();
			$element->create($pais);
			array_push($paisesArr, $element);
		}
	}

    // GETTING TRABAS //
	$trabas = $query->index($conn, 'trabas');
	$trabasArr = [];

	if(count($trabas) > 0){
		foreach($trabas as $traba){
			$element = new Trabas();
			$element->create($traba);
			array_push($trabasArr, $element);
		}
	}

    //REQUEST UPDATE MODAL
    if($_SERVER["REQUEST_METHOD"] === "POST" && 
        isset($_POST['id_traba'])){
        
        $trabaToEdit = getModel($trabasArr, $_POST['id_traba']);                   
        $pais = getModel($paisesArr, $trabaToEdit->getPais());

        $response = json_encode([
            'status' => 200,
            'data' => [
                'traba' => [
                    'id' => $trabaToEdit->getId(),
                    'nombre' => $trabaToEdit->getNombre(),
                    'ciudad' => $trabaToEdit->getCiudad() ?? null,
                ],
                'pais'  => $pais,
            ],
        ]);
        
        header('Content-Type: application/json');
        echo $response;
        exit(); 
    }

    // UPDATE / DELETE TRABA	
    if($_SERVER["REQUEST_METHOD"] === "POST" && 
        !isset($_POST['id_traba']) && 
        (isset($_POST['modal_trabas']) || isset($_POST['delete_key']))
    ){ 

        $result = null;
        
        //UPDATE
        if(isset($_POST['modal_trabas']) && $_POST['modal_trabas'] === 'Actualizar'){
            $id = $_POST['traba_id'];
            $result = $query->update(
                $conn, 
                'trabas', 
                [
                    'nombre' => $_POST['nombre'],
                    'pais' => $_POST['pais'],
                    'ciudad' => $_POST['ciudad']
                ],
                "id = $id"
            );
            if($result !== true){
                $thrownMessage = throwMessage('required'); 
            }else{            
                $thrownMessage = throwMessage('success', 'Traba');
            }
        }

        //DELETE
        if(isset($_POST['delete_key'])){
            $nombre = $_POST['delete_key'];
            $result = $query->delete(
                $conn, 
                'trabas',
                "nombre = '$nombre'"
            );
            if($result !== true){
                if(strpos($result->getMessage(), 'constraint')){
                    $thrownMessage = throwMessage(
                        'custom', 
                        'Hay gallos registrados que pertenecen a esta traba 
                        y no se puede borrar. modifique los gallos e intente de nuevo.'
                    );
                }else{
                    $thrownMessage = throwMessage('custom', 'Hubo un error al borrar la traba');
                }
            }else{
                header("Location:".$_SERVER['PHP_SELF'].'/trabas');
            }
        }
    }

  	//SAVE TRABA
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : null;
    $pais = isset($_POST['pais']) ? htmlspecialchars($_POST['pais']) : null;
    $ciudad = isset($_POST['ciudad']) ? htmlspecialchars($_POST['ciudad']) : null;

    $paisPreseleccionado = null;	

	if($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['id_traba'])
        && !isset($_POST['traba_id']) && !isset($_POST['delete_key'])){

        $paisPreseleccionado = getModel($paisesArr, $pais);	
        $requiredKeys = [
            'nombre', 
            'pais',
            'ciudad',
        ];
        $validations = emptyRequiredValues($_POST, $requiredKeys);
		
        if($validations[0] > 0){
            $thrownMessage = throwMessage('required');                 
        } else {
            $traba = new Trabas();
		    $traba->create([
		        'nombre' => $nombre,
		        'pais' => $pais,
                'ciudad' => $ciudad,
		    ]);
		
		    $result = $traba->save($conn, 'trabas', $traba->getElements());
            if($result !== true){
                if(strpos($result, 'nombre')){
                    $thrownMessage = throwMessage('duplicated', $nombre);   
                }else{
                    $thrownMessage = throwMessage('required', $nombre);   
                }
            }else{  
                $thrownMessage = throwMessage('success', 'Traba');                 

            }
        }
    }