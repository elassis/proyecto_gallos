<?php
 
  	include_once 'queries.php';

  	class Gallos extends Queries
    { 
		protected $id;
        protected $codigo;
        protected $codigoColiseo;
		protected $nombre;
		protected $color;
		protected $pais;
		protected $genero;
		protected $dueno;
		protected $fechaNacimiento;
		protected $peso;
		protected $cresta;
		protected $fotoUno;
		protected $fotoDos;
		protected $traba;
		protected $observaciones;

		
		// Getter and Setter methods for $id
		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

        // Getter and Setter methods for $id
		public function getCodigo() {
			return $this->codigo;
		}

		public function setCodigo($codigo) {
			$this->codigo = $codigo;
		}

        // Getter and Setter methods for $id
		public function getCodigoColiseo() {
			return $this->codigoColiseo;
		}

		public function setCodigoColiseo($codigoColiseo) {
			$this->codigoColiseo = $codigoColiseo;
		}

		// Getter and Setter methods for $nombre
		public function getNombre() {
			return $this->nombre;
		}

		public function setNombre($nombre) {
			$this->nombre = $nombre;
		}

		// Getter and Setter methods for $color
		public function getColor() {
			return $this->color;
		}

		public function setColor($color) {
			$this->color = $color;
		}

		// Getter and Setter methods for $pais
		public function getPais() {
			return $this->pais;
		}

		public function setPais($pais) {
			$this->pais = $pais;
		}

		// Getter and Setter methods for $genero
		public function getGenero() {
			return $this->genero;
		}

		public function setGenero($genero) {
			$this->genero = $genero;
		}

		// Getter and Setter methods for $dueno
		public function getDueno() {
			return (int)$this->dueno;
		}

		public function setDueno($dueno) {
			$this->dueno = $dueno;
		}
		
		// Getter and Setter methods for $fechaNacimiento
		public function getFechaNacimiento() {
			return $this->fechaNacimiento;
		}

		public function setFechaNacimiento($fechaNacimiento) {
			$this->fechaNacimiento = $fechaNacimiento;
		}

		// Getter and Setter methods for $peso
		public function getPeso() {
			return $this->peso;
		}

		public function setPeso($peso) {
			$this->peso = $peso;
		}

		// Getter and Setter methods for $cresta
		public function getCresta() {
			return $this->cresta;
		}

		public function setCresta($cresta) {
			$this->cresta = $cresta;
		}

		// Getter and Setter methods for $traba
		public function getTraba() {
			return $this->traba;
		}

		public function setTraba($traba) {
			$this->traba = $traba;
		}
	
		// Getter and Setter methods for $traba
		public function getObservaciones() {
			return $this->observaciones;
		}

		public function setObservaciones($observaciones) {
			$this->observaciones = $observaciones;
		}

		public function create($array)
		{
			if(isset($array['id'])){
			  $this->setId($array['id']);
			}
			$this->setCodigo($array['codigo_gallo']);
			$this->setNombre($array['nombre']);
			$this->setColor($array['color']);
			$this->setPais($array['pais']);
			$this->setGenero($array['genero']);
			$this->setDueno($array['dueno']);
			$this->setFechaNacimiento($array['fecha_nacimiento']);
			$this->setPeso($array['peso']);
			$this->setCresta($array['cresta']);			
			$this->setTraba($array['traba']);
            $this->setCodigoColiseo($array['codigo_coliseo']);
			$this->setObservaciones($array['observaciones']);
		}

		public function getElements()
		{
			return $data = [
            'codigo_gallo' => $this->getCodigo(),
			'nombre' => $this->getNombre(),
			'color' => $this->getColor(),
			'pais' => $this->getPais(),
			'genero' => $this->getGenero(),
			'dueno' => $this->getDueno(),
			'fecha_nacimiento' => $this->getFechaNacimiento(),
			'peso' => $this->getPeso(),
			'cresta' => $this->getCresta(),
			'traba' => $this->getTraba(),
            'codigo_coliseo' => $this->getCodigoColiseo(),
			'observaciones' => $this->getObservaciones(),
			];
		}

}
