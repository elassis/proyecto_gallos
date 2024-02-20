<?php
	include_once 'functions.php';
	include_once 'Classes/paises.php';
	include_once 'Classes/queries.php';


	$conn = connect();

    $modal_title = 'Editar pais';

    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : null;
    
	$thrownMessage = null;
    $deleteTitle = "Eliminar Pais";
    $deleteText = "Esta seguro desea eliminar este pais?"; 

    $query = new Queries();


    //GET PAISES
    $paisesArr = [];
    $paises = $query->index($conn, 'paises');

	if(count($paises) > 0){
		foreach($paises as $pais){
			$element = new Paises();
			$element->create($pais);
			array_push($paisesArr, $element);
		}
	}

    //DATA EDIT MODAL
	if($_SERVER["REQUEST_METHOD"] === "POST" && 
        isset($_POST['id_pais'])){
        $paisToEdit = getModel($paisesArr, $_POST['id_pais']);
        $response = json_encode([
            'status' => 200,
            'data' => $paisToEdit,
        ]);
        header('Content-Type: application/json');
        echo $response;
        exit();
    }

    // UPDATE / DELETE PAIS	
    if($_SERVER["REQUEST_METHOD"] === "POST" && 
        !isset($_POST['id_pais']) && 
        (isset($_POST['modal_paises']) || isset($_POST['delete_key']))
    ){ 

        $result = null;
        
        //UPDATE
        if(isset($_POST['modal_paises']) && $_POST['modal_paises'] === 'Actualizar'){
            $id = $_POST['pais_id'];
            $result = $query->update(
                $conn, 
                'paises', 
                ['nombre' => $_POST['nombre']],
                "id = $id"
            );
            if($result !== true){
                if(strpos($result, 'nombre')){
                    $thrownMessage = throwMessage('duplicated', $nombre);   
                }else{
                    $thrownMessage = throwMessage('required'); 
                }
            }else{            
                header("Location:".$_SERVER['PHP_SELF'].'/paises');
                $thrownMessage = throwMessage('success', 'Pais');
            }
        }

        //DELETE
        if(isset($_POST['delete_key'])){
            $nombre = $_POST['delete_key'];
            $result = $query->delete(
                $conn, 
                'paises',
                "nombre = '$nombre'"
            );
            if($result !== true){
                if(strpos($result->getMessage(), 'trabas_paises_id')){
                    $thrownMessage = throwMessage('custom', 
                        'No se puede eliminar un paises que este en uso'
                    );
                }else{
                    $thrownMessage = throwMessage('custom', 
                        'Hubo un error al borrar el pais'
                    ); 
                }
            }else{
                header("Location:".$_SERVER['PHP_SELF'].'/paises');
            }
        }
    }

   
    // SAVE PAIS	
	if($_SERVER["REQUEST_METHOD"] === "POST" && 
        !isset($_POST['id_pais']) &&
        !isset($_POST['modal_paises']) &&
        !isset($_POST['delete_key'])){
	    $pais = new Paises();
		$pais->create(['nombre' => $nombre]);
		$result = $pais->save($conn, 'paises', ['nombre' => $pais->getNombre()]);			
        if($result !== true){
            if(strpos($result, 'nombre')){
                $thrownMessage = throwMessage('duplicated', $nombre);   
            }else{
                $thrownMessage = throwMessage('required'); 
            }
        }else{            
            $thrownMessage = throwMessage('success', 'Pais');
        }
    }
