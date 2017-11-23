<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShoppingCart
 *
 * @author Willian Vieira
 */
class SalesItem {

    private $id;
    private $qtd;
    private $cor;
    private $tam;
    
    function __construct($id, $qtd, $cor, $tam) {
        $this->id = $id;
        $this->qtd = $qtd;
        $this->cor = $cor;
        $this->tam = $tam;
    }

    function getId() {
        return $this->id;
    }

    function getQtd() {
        return $this->qtd;
    }

    function getCor() {
        return $this->cor;
    }

    function getTam() {
        return $this->tam;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    function setCor($cor) {
        $this->cor = $cor;
    }

    function setTam($tam) {
        $this->tam = $tam;
    }

 
}

?>