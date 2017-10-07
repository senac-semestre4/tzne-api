<?php

header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR.'/Dao/DaoProducts.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Product.php';


$p = new Product();

$p->setName("p1"); 
$p->setModel("model"); 
$p->setCode(0); 
$p->setSpecification("especificação"); 
$p->setDepartament(1); 
$p->setPurchase_price(10.0); 
$p->setProfit_margin(10.0); 
$p->setPromotional_price(0.0); 
$p->setLength(1.0); 
$p->setWidth(1.0); 
$p->setHeigth(1.0); 
$p->setStock_quantity(1); 
$p->setImg_relative_url("sdsds"); 
$p->setStatus(true); 
$p->setBrands_brand_id(1);
$p->setDepartaments_departament_id(1);
$p->setId(46);





$dao = new DaoProducts;

$dao->updateProduct($p);


?>
