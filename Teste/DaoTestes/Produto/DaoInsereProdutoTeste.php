<?php

header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR.'/Dao/DaoProducts.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Product.php';

$p = new Product();
$p->setId(null);
$p->setName("Teste"); 
$p->setModel("teste"); 
$p->setCode(123); 
$p->setSpecification("especificação"); 
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
$p->setTshirtColor(1);
$p->setTshirtSize(2);


$options = new ProductOpitons();
$options->setQtd(10);
$options->setColor(3);
$options->setSize(2);

$options1 = new ProductOpitons();
$options1->setQtd(10);
$options1->setColor(4);
$options1->setSize(3);

$options2 = new ProductOpitons();
$options2->setQtd(10);
$options2->setColor(2);
$options2->setSize(3);

$array = array();


$array[] = $options;
$array[] = $options1;
$array[] = $options2;



//echo var_dump($array);


$dao = new DaoProducts;

$dao->insertProduct($p, $array);


?>
