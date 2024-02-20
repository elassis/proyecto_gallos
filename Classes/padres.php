<?php
  include_once 'queries.php';

  class Padres
  {
      protected $id;
      protected $codigoGallo;      
      protected $codigoPadre; 
      protected $codigoMadre; 

    
      // Getter and Setter methods for $id
      public function getId() {
          return $this->id;
      }

      public function setId($id) {
        $this->id = $id;
      }

      // Getter and Setter methods for $CodigoPadre
      public function getCodigoGallo() {
          return $this->codigoGallo;
      }

      public function setCodigoGallo($codigoGallo) {
          $this->codigoGallo = $codigoGallo;
      }    
      
      // Getter and Setter methods for $CodigoPadre
      public function getCodigoPadre() {
          return $this->codigoPadre;
      }

      public function setCodigoPadre($codigoPadre) {
          $this->codigoPadre = $codigoPadre;
      }

      // Getter and Setter methods for $CodigoPadre
      public function getCodigoMadre() {
          return $this->codigoMadre;
      }

      public function setCodigoMadre($codigoMadre) {
          $this->codigoMadre = $codigoMadre;
      } 


      public function create($array)
      {
            $this->setId($array['id']);
            $this->setCodigoGallo($array['codigo_gallo']); 
            $this->setCodigoPadre($array['codigo_padre']);
            $this->setCodigoPadre($array['codigo_madre']);
      }

    
}