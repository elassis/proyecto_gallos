<?php
    require_once 'functions.php';
    require_once 'Classes\gallos.php';	
	require_once 'Classes\paises.php';	
	require_once 'Classes\trabas.php';
	require_once 'Classes\crestas.php';
    require_once 'Classes\queries.php';
    require_once 'Classes\peleas.php';
    require_once 'local_folder.php';


    $conn = connect();
    $pelea_id = null;
    $thrownMessage = null;  
    $deleteText = 'Esta seguro que desea Eliminar este Gallo?';
    $deleteTitle = 'Eliminar Gallo';
    $resultadosArr = [
        'g' => 'ganador',
        'p' => 'perdedor',
        't' => 'tabla',
    ];
    
	$query = new queries();

    function deleteRow($query, $conn, $id, $class)
    {
        if($class === 'gallo'){
            $deleteFotos = $query->delete(
                $conn, 
                'fotos_gallos', 
                "gallo_id = $id"
            );
    
            if($deleteFotos){
                $deleteGallo = $query->delete(
                    $conn, 
                    'gallos', 
                    "id = $id"
                );
                if($deleteGallo){
                    header('Location: '.$_SERVER['PHP_SELF'].'/mis-gallos');
                }else{
                    $thrownMessage = throwMessage('custom', 'hubo un error al eliminar');
                }
            }
        }
        if($class === 'pelea'){
            $deletePelea = $query->delete(
                $conn, 
                'peleas', 
                "id = $id"
            );
            if($deletePelea !== true){
                $thrownMessage = throwMessage('custom', 'hubo un error al eliminar');
            }
        }
    }
    
    if(isset($_GET['gallo_id'])){
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
        
        $galloId = $_GET['gallo_id'];
        
        $queries = new Queries();    
        
        $gallo = new Gallos();
        
        $data = $queries->gallosJoinTrabasCrestas($conn, $galloId);
        
        $gallo->create($data[0]);

        
        // SELECT values
        $paisPreseleccionado = getModel($paisesArr, $gallo->getPais(), 'nombre');
        $trabaPreseleccionado = getModel($trabasArr, $gallo->getTraba(), 'nombre');
        $crestaPreseleccionado = getModel($crestasArr, $gallo->getCresta(), 'nombre');
        
        //GETTING PELEAS
        $dataPeleas = $queries->peleasJoinColiseos($conn, $galloId);
        
        
        $arrayPeleas = [];
        foreach($dataPeleas as $pelea){
            $element = new Peleas();
            $element->create($pelea);
            $arrayPeleas[] = $element;
        }
        
        //GETTING IMAGES
        $images = $queries->select($conn, 'fotos_gallos', 'gallo_id', $galloId);

        $foto_1 = isset($images) ? foundInArray($images, 'foto_1') : null;
        $foto_2 = isset($images) ? foundInArray($images, 'foto_2') : null;
           
    }

    
     
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_button'])){
        deleteRow($query, $conn, $_GET['gallo_id'], 'gallo');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit_pelea'])){
        $requiredKeys = [
            'gallo', 
            'fecha', 
            'coliseo',
            'minutos',
            'segundos',
            'resultado',
            'contrincante', 
        ];
        $validations = emptyRequiredValues($_POST, $requiredKeys);
        if($validations[0] > 0){
            $thrownMessage = throwMessage('required');             
        }else{
            $element = new Peleas();
            $result = null;
            if($_POST['submit_pelea'] === 'Guardar'){
                $element->create($_POST);
                $result = $element->save($conn, 'peleas', $element->getElements());
            }else {
                $pelea_id = $_POST['pelea_id'];
                unset($_POST['pelea_id']);
                $_POST['id'] = $pelea_id;
                $element->create($_POST);
                $result = $element->update($conn, 'peleas', $element->getElements(), "id = $pelea_id");
            }

            if($result !== true){
                $thrownMessage = throwMessage('required');
            }else{              
                $coliseo = null;  
                $fecha = null;  
                $contrincante = null;                
                $resultado =null;           
                $minutos = null;      
                $segundos = null;        
                $observaciones = null;
                $coliseoPreseleccionado = null;
                $galloPreseleccionado = null;
                header('Location: '.$_SERVER['PHP_SELF'].'/mi-gallo?gallo_id='.$gallo->getId());

            }
        } 
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && 
    isset($_POST['pelea_id'])){
        $pelea_id = $_POST['pelea_id'];
        $peleaToEdit = getModel($arrayPeleas, $_POST['pelea_id']);
        if($peleaToEdit){
            $coliseoData = $queries->selectValues(
                $conn, 
                'coliseos',
                'nombre',
                ['id'],
                $peleaToEdit->getColiseo()
            );
            $data = [
                'id' => $peleaToEdit->getId(),
                'gallo' => $_GET['gallo_id'],
                'contrincante' => $peleaToEdit->getcontrincante(),                
                'fecha' => $peleaToEdit->getFecha(),  
                'coliseo' => [$peleaToEdit->getColiseo(), $coliseoData[0]->id],
                'resultado' => [$resultadosArr[$peleaToEdit->getResultado()], $peleaToEdit->getResultado()],           
                'minutos' => $peleaToEdit->getMinutos(),      
                'segundos' => $peleaToEdit->getSegundos(),        
                'observaciones' => $peleaToEdit->getObservaciones(),

            ];
            $response =  json_encode([
                'status' => 200,
                'payload' => $data,
            ]);
            header('Content-Type: application/json');
            echo $response;
            exit();
        };
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && 
    isset($_POST['pelea_eliminar_id'])){
        deleteRow($query, $conn, $_POST['pelea_eliminar_id'], 'pelea');
        header('Content-Type: application/json');
        $response =  json_encode([
            'status' => 200,
        ]);
        echo $response;
        exit();
    }
 

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['actualizar']){
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
            unset($_POST['actualizar']);
            $result = $query->update($conn, 'gallos', $_POST, "id = $galloId");
            if($result !== true){
                $thrownMessage = throwMessage('custom', 'Hubo un error al guardar, contacte al administrador del sistema');
            }else{
                if(count($_FILES) > 0){
                    if($_FILES['foto_1']['name']){
                        $photoName = savePhoto(
                            $_FILES['foto_1']["name"],
                            $_FILES['foto_1']["tmp_name"], 
                            $LOCAL_FOLDER
                        );
                        if($photoName[0] !== true){
                            $thrownMessage = throwMessage('photoError', 'Foto 1'); 
                        }else {
                            if($images && $foto_1){
                                $fotoUpdateResult = $query->update(
                                    $conn, 'fotos_gallos',
                                    ['nombre_foto' => $photoName[1]], 
                                    "gallo_id = $galloId AND numero_foto = 'foto_1'"
                                );
                                if($fotoUpdateResult !== true){
                                    $thrownMessage = throwMessage(
                                        'custom', 
                                        'Error al actualizar Foto 1 en BD.'
                                    );  
                                }
                            }else{
                                $fotoSaveResult = $query->save(
                                    $conn, 
                                    'fotos_gallos', 
                                    $arr = [
                                        'nombre_foto' => $photoName[1],
                                        'numero_foto' => 'foto_1',
                                        'gallo_id'    => $galloId,
                                    ]
                                );
                                if($fotoSaveResult !== true){
                                    $thrownMessage = throwMessage(
                                        'custom', 
                                        'Error al guardar Foto 1 en BD.'
                                    );  
                                }
                            }
                        }
                    }
                    if($_FILES['foto_2']['name']){
                        $photoName = savePhoto(
                            $_FILES['foto_2']["name"],
                            $_FILES['foto_2']["tmp_name"], 
                            $LOCAL_FOLDER
                        );
                        if($photoName[0] !== true){
                            $thrownMessage = throwMessage('photoError', 'Foto 2'); 
                        }else {
                            if($images && $foto_2)
                                {
                                $fotoUpdateResult = $query->update(
                                    $conn, 'fotos_gallos',
                                    ['nombre_foto' => $photoName[1]], 
                                    "gallo_id = $galloId AND numero_foto = foto_2"
                                );
                                if($fotoUpdateResult !== true){
                                    $thrownMessage = throwMessage(
                                        'custom', 
                                        'Error al actualizar Foto 2 en BD.'
                                    );  
                                }
                            }else{
                                $fotoSaveResult = $query->save(
                                    $conn, 
                                    'fotos_gallos', 
                                    $arr = [
                                        'nombre_foto' => $photoName[1],
                                        'numero_foto' => 'foto_2',
                                        'gallo_id'    => $galloId,
                                    ]
                                );
                                if($fotoSaveResult !== true){
                                    $thrownMessage = throwMessage(
                                        'custom', 
                                        'Error al guardar Foto 2 en BD.'
                                    );  
                                }
                            }
                        }
                    }
                } else {
                    header('Location: '.$_SERVER['PHP_SELF'].'/mi-gallo?gallo_id='.$gallo->getId());
                }
            }
        }
    } 
?>