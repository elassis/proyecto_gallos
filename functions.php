<?php
  //CONNECTION FUNCTION
    function connect()
    {
        $result = null;
        $servername = "localhost"; // Replace 'localhost' with your server name
        $username = "root"; // Replace 'username' with your MySQL username
        $password = ""; // Replace 'password' with your MySQL password
        $dbname = "projecto_gallos"; // Replace 'database_name' with your database name
    
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $result = $conn;
    
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }
        
        return $result;
    }

    //VALIDATION FUNCTION
    /**
     * check if there's a required value empty
     * 
     * @param array $entries
     * @param array $requiredKeys
     * 
     * @return Number
     */
    function emptyRequiredValues($entries, $requiredKeys)
    {
        $emptyValues = 0;
        $missingValues = [];
        
        foreach($requiredKeys as $requiredKey){
            if($entries[$requiredKey] == '' || $entries[$requiredKey] == 'No' ||
                $entries[$requiredKey] == 'N/A'){
                $emptyValues++;
                $missingValues[] = $requiredKey;
            };
        }

        return [$emptyValues, $missingValues];
    }

    /**
     * extract the preselected class model
     * 
     * @param array $arrayOfModels
     * @param int $modelId
     * @param string $key
     * 
     * @return $model
     */
    function getModel($arrayOfModels, $param, $key = 'id'){
        
        $modelToReturn = null;
        
        if($key === 'id'){
            foreach($arrayOfModels as $givenModel){
                if($givenModel->getId() == $param){
                    $modelToReturn = $givenModel;
                }
            }
        }else if($key === 'nombre'){
            foreach($arrayOfModels as $givenModel){
                if($givenModel->getNombre() == $param){
                    $modelToReturn = $givenModel;
                }
            }
        }

        return $modelToReturn;
    }

    /**
     * save rooster photos
     * 
     * @param string $photoName
     * @param string $tempName
     * @param string $localFolderPath
     * 
     * @return string $newName
     * 
     */
    function savePhoto($photoName, $tempLocation, $localFolderPath)
    {
        try {
            $imageName = $photoName;
            $imageTempLocation = $tempLocation;
            $imageExt = explode('.', $imageName);
            $imageActualExt = strtolower(end($imageExt));

            $newName = uniqid(''. true).'.'. $imageActualExt;
            $newDestination = $localFolderPath . $newName;
            move_uploaded_file($imageTempLocation, $newDestination);
            return [true, $newName];
        }catch ( Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *  throw messages through application
     * 
     * @param string $messageType
     * @param string $customValue
     * 
     * @return string $message
     * 
     */
    function throwMessage($messageType, $customValue = null)
    {   
        $message = null;
        if($messageType === 'duplicated'){
            $message = 'El valor \''. $customValue .'\' ya existe en la base de datos, intente un valor distinto';
        }

        if($messageType === 'requiredSpecific'){
            $message = 'El campo '.$customValue.' es requerido';
        }

        if($messageType === 'required'){
            $message = 'Hubo un error al guardar, verifique los campos requeridos';          
        }

        if($messageType === 'photoError'){
            $message = 'Hubo un error al guardar '. $customValue;          
        }

        if($messageType === 'success'){
            $message = $customValue . ' Guardado correctamente';
        }
        if($messageType === 'custom'){
            $message = $customValue;
        }

        return $message;

    }
    /**
     * return array where the value is
     * 
     * @param array $array
     * @param string $key
     * 
     * @return mixed array|null
     */

    function foundInArray($array, $key)
    {
        foreach($array as $level){
            if(in_array($key, $level)){
                return $level;
            } 
        }     
        return null;
        
    }

    /**
     * get the requested object by key
     * 
     * @param string $string
     * @param array $array
     * 
     * @return object $filteredObject
     */

    function findInArrayObjects($string, $objectsArr, $type)
    {
        // Custom callback function to filter by object property
        $filterCallback = function ($obj) use ($string, $type) {

            if($type === 'nombre'){
                return strpos($obj->getNombre(), $string) !== false;
            }
            if($type === 'id'){
                return strpos($obj->getId(), $string) !== false;
            }


            // Adjust this condition based on your specific requirements
        };

        // Use array_filter with the custom callback function
        $filteredObjects = array_filter($objectsArr, $filterCallback);        
        return $filteredObjects;
    }

    /**
     * redirect to correct url
     */
    function goToUrl($url)
    {
        $host = !strpos($_SERVER['HTTP_HOST'], 'localhost') ? "/wordpress/"
        : "https:/".$_SERVER['HTTP_HOST']."/";
        
        return $host.$url; 
    }

    function component(
        $kind = 'input', 
        $type = 'text', 
        $name = '', 
        $class = '', 
        $id = '', 
        $value = '', 
        $placeholder = '', 
        $innerHTML = '', 
        $attributes = ''
        )
        {
            switch ($kind) {
                case 'input':
                    return 
                    '<input type="'.$type.'" name="'.$name.'" class="'.$class.'" value="'.$value.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$attributes.' />';
                    break;
                case 'option':
                    return 
                    '<option class="'.$class.'" name="'.$name.'" value="'.$value.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$attributes.'>'.$innerHTML.'</option>';
                    break;
                case 'textarea':
                    return 
                    '<textarea class="'.$class.'" name="'.$name.'" value="'.$value.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$attributes.'>'.$innerHTML.'</textarea>';
                    break;
                
                default:
                    # code...
                    break;
            }
        }

