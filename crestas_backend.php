<?php
	include_once 'functions.php';
	include_once 'Classes/queries.php';
	include_once 'Classes/crestas.php';

	$conn = connect();

    $thrownMessage = null;
    $query = new Queries();
    $modal_title = 'Editar Cresta';
    $deleteTitle = 'Eliminar Cresta';
    $deleteText = 'Esta seguro desea eliminar esta cresta?';
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : null;

    // GETTING CRESTAS //
    $crestas = $query->index($conn, 'crestas');
    $crestasArr = [];

    if(count($crestas) > 0){
        foreach($crestas as $cresta){
            $element = new Crestas();
            $element->create($cresta);
            array_push($crestasArr, $element);
        }
    }

    //REQUEST UPDATE MODAL
    if($_SERVER["REQUEST_METHOD"] === "POST" && 
    isset($_POST['id_cresta'])){

    $crestaToEdit = getModel($crestasArr, $_POST['id_cresta']);

    $response = json_encode([
        'status' => 200,
        'data' => [
            'cresta' => [
                'id' => $crestaToEdit->getId(),
                'nombre' => $crestaToEdit->getNombre(),
            ],
        ],
    ]);

    header('Content-Type: application/json');
    echo $response;
    exit(); 
    };

    // UPDATE / DELETE TRABA	
    if($_SERVER["REQUEST_METHOD"] === "POST" && 
        !isset($_POST['id_cresta']) && 
        (isset($_POST['modal_crestas']) || isset($_POST['delete_key']))
    ){ 

        $result = null;
        
        //UPDATE
        if(isset($_POST['modal_crestas']) && $_POST['modal_crestas'] === 'Actualizar'){
            $id = $_POST['cresta_id'];
            $result = $query->update(
                $conn, 
                'crestas', 
                ['nombre' => $_POST['nombre']],
                "id = $id"
            );
            if($result !== true){
                $thrownMessage = throwMessage('required'); 
            }else{            
                header("Location:".$_SERVER['PHP_SELF'].'/crestas');
            }
        }

        //DELETE
        if(isset($_POST['delete_key'])){
            $nombre = $_POST['delete_key'];
            $result = $query->delete(
                $conn, 
                'crestas',
                "nombre = '$nombre'"
            );
            if($result !== true){
                if(strpos($result->getMessage(), 'constraint')){
                    $thrownMessage = throwMessage(
                        'custom', 
                        'Hay gallos registrados con esta cresta
                        y no se puede borrar. modifique los gallos e intente de nuevo.'
                    );
                }else{
                    $thrownMessage = throwMessage('custom', 'Hubo un error al borrar la cresta');
                }
            }else{
                header("Location:".$_SERVER['PHP_SELF'].'/crestas');
            }
        }
    }

	//SAVE CRESTA    
	if($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['id_cresta'])
    && !isset($_POST['cresta_id']) && !isset($_POST['delete_key'])){
		$cresta = new Crestas();
		$cresta->create(['nombre' => $nombre]);
		$result = $cresta->save($conn, 'crestas', $cresta->getElements());			
        if($result !== true){
            $thrownMessage = throwMessage('duplicated', $nombre); 
        }else{
            header("Location:".$_SERVER['PHP_SELF'].'/crestas');
            $thrownMessage = throwMessage('success', 'Cresta');
            $nombre = null;
        }
    }
