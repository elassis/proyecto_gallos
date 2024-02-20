<?php

	require_once 'functions.php';
	require_once 'Classes\gallos.php';	
	require_once 'Classes\queries.php';
	require_once 'Classes\coliseos.php';
    require_once 'Classes\peleas.php';

	$conn = connect();

	$query = new queries();

	//GETTING USER
	$userId = get_current_user_id();

    //GETTING COLLISEOS
	$coliseos = $query->index($conn, 'coliseos');
	$coliseosArr = [];

	if(count($coliseos) > 0){
		foreach($coliseos as $coliseo){
			$element = new Coliseos();
			$element->create($coliseo);
			array_push($coliseosArr, $element);
		}
	}
    
    //GETTING GALLOS
    $gallos = $query->index($conn, 'gallos');
    $userGallosArr = [];

	if(count($gallos) > 0){
		foreach($gallos as $gallo){
			$element = new Gallos();
			$element->create($gallo);
            if($element->getDueno() == $userId){
                array_push($userGallosArr,$element);
		    }
        }
	}

    $thrownMessage = null;
    $coliseo = isset($_POST['coliseo']) ? htmlspecialchars($_POST['coliseo']) : null;
    $gallo = isset($_POST['gallo']) ? htmlspecialchars($_POST['gallo']) : null;
    $fecha = isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : null;
    $contrincante = isset($_POST['contrincante']) ? htmlspecialchars($_POST['contrincante']) : null;
    $resultado = isset($_POST['resultado']) ? htmlspecialchars($_POST['resultado']) : null;
    $minutos = isset($_POST['minutos']) ? htmlspecialchars($_POST['minutos']) : null;
    $segundos = isset($_POST['segundos']) ? htmlspecialchars($_POST['segundos']) : null;
    $observaciones = isset($_POST['observaciones']) ? htmlspecialchars($_POST['observaciones']) : null;
    $coliseoPreseleccionado = null;
    $galloPreseleccionado = null;

    $resultadosArr = [
        'g' => 'ganador',
        'p' => 'perdedor',
        't' => 'tabla',
    ];
	
	//SAVE PELEA
	 $message = null;
	 if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Guardar'])){
        $coliseoPreseleccionado = getModel($coliseosArr, $coliseo);
        $galloPreseleccionado = getModel($userGallosArr, $gallo);
        
        $requiredKeys = [
            'coliseo', 
            'gallo',
            'fecha', 
            'contrincante', 
            'resultado',
            'minutos',
            'segundos',
        ];
        $validations = emptyRequiredValues($_POST, $requiredKeys);

        if($validations[0] > 0){
            $thrownMessage = throwMessage('required'); 
        } else {
            $element = new Peleas();
            $element->create($_POST);
            $result = $element->save($conn, 'peleas', $element->getElements());
            if($result !== true){
                $thrownMessage = throwMessage('required');
            }else{
                $thrownMessage = throwMessage('success','Pelea');
                
                $coliseo = null;      
                $gallo = null;  
                $fecha = null;  
                $contrincante = null;                
                $resultado =null;           
                $minutos = null;      
                $segundos = null;        
                $observaciones = null;
                $coliseoPreseleccionado = null;
                $galloPreseleccionado = null;
            }
        }
	 }

?>