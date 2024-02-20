<?php
  	include_once 'queries.php';

  	class CodigosColiseo extends Queries
  	{
		protected $id;
		protected $galloId;
		protected $codigo;
		

		
		// Getter and Setter methods for $id
		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		// Getter and Setter methods for $Nombre
		public function getGalloId() {
			return $this->galloId;
		}

		public function setGalloId($galloId) {
			$this->galloId = $galloId;
		}

		// Getter and Setter methods for $Pais  
		public function getCodigo() {
			return $this->codigo;
		}

		public function setCodigo($codigo) {
			$this->codigo = $codigo;
		}		

		public function create($array)
		{
			if(isset($array['id'])){
				$this->setId($array['id']);
			}
			$this->setGalloId($array['gallo_id']);
			$this->setCodigo($array['codigo']);
		}

		public function getElements()
		{
			return $data = [
                'gallo_id' => $this->getGalloId(),
				'codigo' => $this->getCodigo()
			];
		}

    
}