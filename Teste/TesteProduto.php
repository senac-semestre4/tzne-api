<?php

require_once  '../Teste/DaoTesteProduct.php';
require_once '../Model/Produtct.php';
//new product
$p = new Produtct();
//add name to product
$p->setName("testeDao");

// new dao test
$d = new DaoTesteProduct();
// insert $p in data base
$d->InsertProduct($p);  
// set new name to $p
$p->setName("nome");


$d->updateProduct($p);

$json = $d->listByID(1);


 //echo $json;
?>
