<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductOpitons
 *
 * @author Willian Vieira
 */
class ProductOpitons {
    
    private $qtd;
    private $color;
    private $size;
    
     
    
    function __construct() {
      }

      function getQtd() {
          return $this->qtd;
      }

      function getColor() {
          return $this->color;
      }

      function getSize() {
          return $this->size;
      }

      function setQtd($qtd) {
          $this->qtd = $qtd;
      }

      function setColor($color) {
          $this->color = $color;
      }

      function setSize($size) {
          $this->size = $size;
      }


}
