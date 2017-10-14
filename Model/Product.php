<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Produtcts
 *
 * @author Willian Vieira
 */
class Product {

    private $id; // int
    private $name;
    private $model;
    private $code; // int
    private $specification;
    private $purchase_price; //float
    private $profit_margin; //float
    private $promotional_price; //float
    private $length; //float
    private $width; //float
    private $heigth; //float
    private $stock_quantity; //int
    private $img_relative_url;
    private $status; // boolean
    private $brands_brand_id; //int
    private $departaments_departament_id; //int
    private $qtd;
    private $tshirtSize;
    private $tshirtColor;

    public function __construct() {
        
    }

    /*
      function Product($id, $name, $model, $code, $specification, $departament, $purchase_price, $profit_margin, $promotional_price, $length, $width, $heigth, $stock_quantity, $img_relative_url, $status, $brands_brand_id, $departaments_departament_id) {
      $this->id = $id;
      $this->name = $name;
      $this->model = $model;
      $this->code = $code;
      $this->specification = $specification;
      $this->departament = $departament;
      $this->purchase_price = $purchase_price;
      $this->profit_margin = $profit_margin;
      $this->promotional_price = $promotional_price;
      $this->length = $length;
      $this->width = $width;
      $this->heigth = $heigth;
      $this->stock_quantity = $stock_quantity;
      $this->img_relative_url = $img_relative_url;
      $this->status = $status;
      $this->brands_brand_id = $brands_brand_id;
      $this->departaments_departament_id = $departaments_departament_id;
      } */

    function getTshirtColor() {
        return $this->tshirtColor;
    }

    function setTshirtColor($tshirtColor) {
        $this->tshirtColor = $tshirtColor;
    }

    function getQtd() {
        return $this->qtd;
    }

    function getTshirtSize() {
        return $this->tshirtSize;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    function setTshirtSize($tshirtSize) {
        $this->tshirtSize = $tshirtSize;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getModel() {
        return $this->model;
    }

    function getCode() {
        return $this->code;
    }

    function getSpecification() {
        return $this->specification;
    }


    function getPurchase_price() {
        return $this->purchase_price;
    }

    function getProfit_margin() {
        return $this->profit_margin;
    }

    function getPromotional_price() {
        return $this->promotional_price;
    }

    function getLength() {
        return $this->length;
    }

    function getWidth() {
        return $this->width;
    }

    function getHeigth() {
        return $this->heigth;
    }

    function getStock_quantity() {
        return $this->stock_quantity;
    }

    function getImg_relative_url() {
        return $this->img_relative_url;
    }

    function getStatus() {
        return $this->status;
    }

    function getBrands_brand_id() {
        return $this->brands_brand_id;
    }

    function getDepartaments_departament_id() {
        return $this->departaments_departament_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setModel($model) {
        $this->model = $model;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setSpecification($specification) {
        $this->specification = $specification;
    }


    function setPurchase_price($purchase_price) {
        $this->purchase_price = $purchase_price;
    }

    function setProfit_margin($profit_margin) {
        $this->profit_margin = $profit_margin;
    }

    function setPromotional_price($promotional_price) {
        $this->promotional_price = $promotional_price;
    }

    function setLength($length) {
        $this->length = $length;
    }

    function setWidth($width) {
        $this->width = $width;
    }

    function setHeigth($heigth) {
        $this->heigth = $heigth;
    }

    function setStock_quantity($stock_quantity) {
        $this->stock_quantity = $stock_quantity;
    }

    function setImg_relative_url($img_relative_url) {
        $this->img_relative_url = $img_relative_url;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setBrands_brand_id($brands_brand_id) {
        $this->brands_brand_id = $brands_brand_id;
    }

    function setDepartaments_departament_id($departaments_departament_id) {
        $this->departaments_departament_id = $departaments_departament_id;
    }

    function serialize() {

        //return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        return get_object_vars($this);
    }

}

?>