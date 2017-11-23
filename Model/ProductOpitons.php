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
    
   private $productQuantity;
    private $color;
    private $size;
    
     
    
    function __construct() {
      }

      function getProductQuantity() {
          return $this->productQuantity;
      }

      function setProductQuantity($productQuantity) {
          $this->productQuantity = $productQuantity;
      }

            function getColor() {
          return $this->color;
      }

      function getSize() {
          return $this->size;
      }

      function setColor($color) {
          $this->color = $color;
      }

      function setSize($size) {
          $this->size = $size;
      }
    function serializeOptions() {
            //echo json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        //return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
	    $a[] = get_object_vars($this);
    return  $a;
    }

}
