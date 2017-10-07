<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author Willian Vieira
 */
require_once  '../Model/Client.php';
require_once  '../Model/Produtct.php';

class Order {

    private $idVenda;
    private $cliente;
    // private $metodoPagamento;
    private $desconto;
    private $data;
    private $itens = array();
    private $total;

    function getIdVenda() {
        return $this->idVenda;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getDesconto() {
        return $this->desconto;
    }

    function getData() {
        return $this->data;
    }

    function getItens() {
        return $this->itens;
    }

    function getTotal() {
        return $this->total;
    }

    function setIdVenda($idVenda) {
        $this->idVenda = $idVenda;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setItens($itens) {
        
        $this->itens = $itens;
    }

    function setTotal($total) {
        $this->total = $total;
    }


    
}
