<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sale
 *
 * @author Willian Vieira
 */


require_once ROOT_DIR . '/Model/SalesItens.php';

class Sale {

    private $saleId;
    private $clientClientId;
    private $totalPartial;
    private $amount;
    private $discount;
    private $typeFreight;
    private $valueFreight;
    private $numberPlots;
    private $SalesItens =  array();
    //private $SalesItens = array();
    //private $SalesItens = array();
   

    function __construct() {
        //$this->SalesItens[]= new SalesItens();
    }
    function getSalesItens() {
        return $this->SalesItens;
    }

    
    
    function setSalesItens($SalesItens) {
        
        array_push($this->SalesItens, $SalesItens);
         
    }

        function getSaleId() {
        return $this->saleId;
    }

    function getClientClientId() {
        return $this->clientClientId;
    }

    function getTotalPartial() {
        return $this->totalPartial;
    }

    function getAmount() {
        return $this->amount;
    }

    function getDiscount() {
        return $this->discount;
    }

    function getTypeFreight() {
        return $this->typeFreight;
    }

    function getValueFreight() {
        return $this->valueFreight;
    }

    function getNumberPlots() {
        return $this->numberPlots;
    }

    function setSaleId($saleId) {
        $this->saleId = $saleId;
    }

    function setClientClientId($clientClientId) {
        $this->clientClientId = $clientClientId;
    }

    function setTotalPartial($totalPartial) {
        $this->totalPartial = $totalPartial;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setDiscount($discount) {
        $this->discount = $discount;
    }

    function setTypeFreight($typeFreight) {
        $this->typeFreight = $typeFreight;
    }

    function setValueFreight($valueFreight) {
        $this->valueFreight = $valueFreight;
    }

    function setNumberPlots($numberPlots) {
        $this->numberPlots = $numberPlots;
    }
    
        function serializeSale() {
        //echo json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        //return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
            
         //   $var1 = get_object_vars($this);
           // $var2 = $this->getSalesItens();
            
          
            
            //echo var_dump(array_merge($var1));
            //echo json_encode(array_merge($var1, $this->getSalesItens()));
            //return $var2;
            return get_object_vars($this);
            //return $this->serializeSaleItens();
    }

}
