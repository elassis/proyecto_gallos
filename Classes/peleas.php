<?php
 
    include_once 'queries.php';

    class Peleas extends Queries
    {
        protected $id;
        protected $coliseo;
        protected $gallo;
        protected $fecha;
        protected $contrincante;
        protected $resultado;
        protected $observaciones;
        protected $minutos;
        protected $segundos;
        
        // Getter and Setter methods for $id
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        // Getter and Setter methods for $coliseo
        public function getColiseo() {
            return $this->coliseo;
        }

        public function setColiseo($coliseo) {
            $this->coliseo = $coliseo;
        }

        // Getter and Setter methods for $gallo 
        public function getGallo() {
            return $this->gallo ;
        }

        public function setGallo($gallo) {
            $this->gallo = $gallo;
        }

        // Getter and Setter methods for $fecha  
        public function getFecha() {
            return $this->fecha;
        }

        public function setFecha($fecha) {
            $this->fecha = $fecha;
        }

        // Getter and Setter methods for $contrincante  
        public function getContrincante() {
            return $this->contrincante;
        }

        public function setContrincante($contrincante) {
            $this->contrincante = $contrincante;
        }

        // Getter and Setter methods for $resultado
        public function getResultado() {
            return $this->resultado;
        }

        public function setResultado($resultado) {
            $this->resultado = $resultado;
        }

        // Getter and Setter methods for $observaciones
        public function getObservaciones() {
            return $this->observaciones;
        }

        public function setObservaciones($observaciones) {
            $this->observaciones = $observaciones;
        }

        // Getter and Setter methods for $tiempo
        public function getMinutos() {
            return $this->minutos;
        }

        public function setMinutos($minutos) {
            $this->minutos = $minutos;
        }

        // Getter and Setter methods for $tiempo
        public function getSegundos() {
            return $this->segundos;
        }

        public function setSegundos($segundos) {
            $this->segundos = $segundos;
        }

        public function create($array)
        {
            if(isset($array['id'])){
                $this->setId($array['id']);
            }

            $this->setgallo($array['gallo']);
            $this->setcoliseo($array['coliseo']);
            $this->setfecha($array['fecha']);
            $this->setcontrincante($array['contrincante']);
            $this->setresultado($array['resultado']);
            $this->setobservaciones($array['observaciones']);
            $this->setMinutos($array['minutos']);
            $this->setSegundos($array['segundos']);
                
        }

        public function getElements()
		{
			return $data = [
                'id' => $this->getId(),
        		'gallo' => $this->getGallo(),
                'coliseo' => $this->getColiseo(),
                'fecha' => $this->getfecha(),
                'contrincante' => $this->getcontrincante(),
                'resultado' => $this->getresultado(),
                'observaciones' => $this->getobservaciones(),
                'minutos' => $this->getMinutos(),
                'segundos' => $this->getSegundos(),
			];
		}
        
    }
