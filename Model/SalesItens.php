<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalesItens
 *
 * @author Willian Vieira
 */
class SalesItens {

    private $itemForSaleId;
    private $saleIdSale;
    private $productProductHasId;
    private $quantity;
    private $subtotal;
    private $date;
    private $informedCli;
    private $comment;

    function __construct() {
        
    }
    function getDate() {
        return $this->date;
    }

    function getInformedCli() {
        return $this->informedCli;
    }

    function getComment() {
        return $this->comment;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setInformedCli($informedCli) {
        $this->informedCli = $informedCli;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

        function getItemForSaleId() {
        return $this->itemForSaleId;
    }

    function getSaleIdSale() {
        return $this->saleIdSale;
    }

    function getProductProductHasId() {
        return $this->productProductHasId;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function setItemForSaleId($itemForSaleId) {
        $this->itemForSaleId = $itemForSaleId;
    }

    function setSaleIdSale($saleIdSale) {
        $this->saleIdSale = $saleIdSale;
    }

    function setProductProductHasId($productProductHasId) {
        $this->productProductHasId = $productProductHasId;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

            function serializeSaleItens() {
        //echo json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        //return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        return get_object_vars($this);
    }
    
}

