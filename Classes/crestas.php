<?php
  include_once 'queries.php';

	class Crestas extends Queries
	{
		protected $id;
		protected $nombre; 

		
		// Getter and Setter methods for $id
		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		// Getter and Setter methods for $Nombre
		public function getNombre() {
			return $this->nombre;
		}

		public function setNombre($nombre) {
			$this->nombre = $nombre;
		}      

		public function create(array $array)
		{
			if(isset($array['id'])){
				$this->setId($array['id']);
			}
			
			$this->setNombre($array['nombre']); 
		}
    
        public function getElements()
		{
			return $data = [
                'nombre' => $this->getNombre(),
			];
		}
	}