<?php
  	include_once 'queries.php';

  	class Trabas extends Queries
  	{
		protected $id;
		protected $nombre;
		protected $pais;
		protected $ciudad;

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

		// Getter and Setter methods for $Pais  
		public function getPais() {
			return $this->pais;
		}

		public function setPais($pais) {
			$this->pais = $pais;
		}		

        // Getter and Setter methods for $Pais  
		public function getCiudad() {
			return $this->ciudad;
		}

		public function setCiudad($ciudad) {
			$this->ciudad = $ciudad;
		}	
		public function create($array)
		{
			if(isset($array['id'])){
				$this->setId($array['id']);
			}
			$this->setNombre($array['nombre']);
			$this->setPais($array['pais']);
			$this->setCiudad($array['ciudad']);

		}

		public function getElements()
		{
			return $data = [
        		'nombre' => $this->getNombre(),
				'pais' => $this->getPais(),
                'ciudad' => $this->getCiudad(),
			];
		}

    
}