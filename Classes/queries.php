<?php

Class Queries {

	//SELECT
  	public function select($connection, $table, $column, $value)
	{
		$stmt = $connection->query("SELECT * FROM $table WHERE $column = $value");
		$result = $stmt->fetchAll();

		return $result;
	}

	public function index($connection, $table)
	{
		$stmt = $connection->query("SELECT * FROM $table");
		$result = $stmt->fetchAll();

		return $result;
	}

  /**
   * get the desired columns from table
   * 
   * @param connection $connection
   * @param string $table      //table
   * @param string $index      //reference column
   * @param string $columnsArr //reference column value
   * @param array $value       //columns to extract
   * 
   * @return object $result
   */
    public function selectValues($connection, $table, $index, $columnsArr, $value, $objFormat = PDO::FETCH_OBJ)
	{
    
        $columns = implode(', ', $columnsArr);
        $stmt = $connection->prepare("SELECT $columns FROM `$table` WHERE `$index` = :val");
        $stmt->bindParam(':val', $value);
        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetchAll($objFormat);

        return $result;
	}

    //JOINS
    public function peleasJoinColiseos($connection, $galloId)
    {
        $sql = "SELECT  
                        peleas.id, 
                        peleas.fecha, 
                        peleas.gallo,
                        peleas.contrincante, 
                        peleas.resultado, 
                        peleas.observaciones,
                        peleas.minutos, 
                        peleas.segundos, 
                        coliseos.nombre as coliseo 
                        FROM `peleas` JOIN coliseos ON peleas.coliseo = coliseos.id 
                        WHERE peleas.gallo = $galloId";

        try {		
            $stmt = $connection->query($sql);
            $result = $stmt->fetchAll();
            return $result;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function gallosJoinTrabasCrestas($connection, $galloId)
    {
        $sql = "SELECT 
                       gallos.id, 
                       gallos.codigo_gallo, 
                       gallos.nombre, 
                       gallos.color, 
                       paises.nombre as pais, 
                       gallos.genero, 
                       gallos.dueno, 
                       gallos.fecha_nacimiento,
                       gallos.codigo_coliseo, 
                       gallos.peso,
                       gallos.observaciones, 
                       trabas.nombre as traba, 
                       crestas.nombre as cresta 
                       FROM gallos JOIN paises ON gallos.pais = paises.id 
                       JOIN crestas ON gallos.cresta = crestas.id 
                       JOIN trabas ON gallos.traba = trabas.id WHERE gallos.id = $galloId";

        try {		
            $stmt = $connection->query($sql);
            $result = $stmt->fetchAll();
            return $result;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function gallosJoinGallosFotos($connection)
    {
        $sql = "SELECT DISTINCT gallos.id, 
                                gallos.nombre, 
                                fotos_gallos.nombre_foto, 
                                fotos_gallos.numero_foto, 
                                fotos_gallos.gallo_id 
                                FROM `gallos` LEFT JOIN fotos_gallos 
                                ON gallos.id = fotos_gallos.gallo_id 
                                GROUP BY gallos.id";

        try {		
            $stmt = $connection->query($sql);
            $result = $stmt->fetchAll();
            return $result;
        } catch (\Throwable $th) {
            return $th;
        }
    }


	//INSERT
	public function save($connection, $table, $array)
	{
		$keysArr = [];
		
		foreach($array as $key => $value){
			array_push($keysArr, $key);  
		}
		
		$stringKeys = implode(', ', $keysArr);
    	$stringPlaceholders = ':' . implode(', :', $keysArr);
		
		try {
			$bindsArr = [];
			$stmt = $connection->prepare("INSERT INTO `$table` ($stringKeys) VALUES ($stringPlaceholders)");
			foreach($array as $key => $value){
				$bindsArr[':' . $key] = $value;
			}
            	
			$stmt->execute($bindsArr);
			return true;
		} catch (\Throwable $th) {
			return $th;
		}

	}
	
	//UPDATE

	public function update($connection, $table, $array, $queryString)
	{		
		$updateArr = [];
		
		foreach($array as $key => $value){
            $realValue = $value === '' ? 'N/A' : $value;
			array_push($updateArr, "`$key` = '$realValue'"); 
		}

		$updateString = implode(', ', $updateArr);		

		$sql = "UPDATE `$table` set $updateString WHERE $queryString";
        //var_dump($sql);

		try {
			//code...
			$stmt = $connection->query($sql);
			return true;
		} catch (\Throwable $th) {
			return $th;
		}
	}
	
	//DELETE
	public function delete($connection, $table, $string)
	{
		try {
			//code...
			$stmt = $connection->query("DELETE FROM $table WHERE $string");
			return true;
		} catch (\Throwable $th) {
			return $th;
		}
	}
}