<?php

header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 
session_start();
session_destroy();
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR . '/Model/Login.php';
require_once ROOT_DIR . '/Model/Product.php';
require_once ROOT_DIR . '/Services/Cart.php';



$p = new Product();
$p->setId(3);
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
$p->setQtd(1);
$p->setTshirtSize("M");
$p->setTshirtColor("Azul");
//echo $p->serialize();

$p2 = new Product();
$p2->setId(2);
$p2->setName("p2");
$p2->setModel("model");
$p2->setCode(0);
$p2->setSpecification("especificação");
$p2->setDepartament(1);
$p2->setPurchase_price(10.0);
$p2->setProfit_margin(10.0);
$p2->setPromotional_price(0.0);
$p2->setLength(1.0);
$p2->setWidth(1.0);
$p2->setHeigth(1.0);
$p2->setStock_quantity(1);
$p2->setImg_relative_url("sdsds");
$p2->setStatus(true);
$p2->setBrands_brand_id(1);
$p2->setDepartaments_departament_id(1);



$login = new Login("wmv", 1236456);
session_start();
unset($_SESSION['sacola']);
unset($_SESSION['logado']);
unset($_SESSION['carrinho']);

//
$_SESSION['sacola'] = array();


$cart = new Cart;
//$cart2 =  new Cart;

if ($cart->createCart()) {
    echo 'Cart criado';
} else {
    echo 'erro1 ';
}

if ($cart->addProduct($p->getId(), $p->getQtd(), $p->getTshirtColor(), $p->getTshirtSize())) {
    echo 'p add';
} else {
    echo 'erro';
}
$cart->addProduct($p2->getId(), $p2->getQtd(), $p2->getTshirtColor(), $p2->getTshirtSize());

//array_push($_SESSION['sacola'], $p);
//$_SESSION['sacola'][0] = $p;
//$_SESSION['sacola'][1] = $p2;
//array_push($_SESSION['sacola'], $p2);
//$json = $p2->serialize();
//
//echo $json;
//
// $json = array();
//

echo "<pre>";
echo "Imprimindo sacola";
echo "</pre>";
for ($i = 0; $i < sizeof($_SESSION['sacola']); $i++) {

    $json [] = $_SESSION['sacola'][$i]->serialize();
}
echo json_encode($json, JSON_PRETTY_PRINT);
//
//
//
//
//
//
//echo "<pre>";;
//echo 'Carrinho com produto sem logar';
//echo "</pre>";
//echo "<pre>";
//echo var_dump($_SESSION['logado']);
//echo var_dump($_SESSION);
//echo "</pre>";
//
////

if ($login->createSession() == false) {
    echo "logad";
    $login->createSession();
} else {


    echo "<pre>";

    echo 'Usuário criado e logado';
    echo "</pre>";
    //echo "<pre>";
    //echo var_dump($_SESSION['logado']);
    //echo var_dump($_SESSION);
    //echo "</pre>";

    for ($i = 0; $i <= sizeof($_SESSION['logado']['carrinho']); $i++) {
        echo json_encode($_SESSION['logado']['carrinho'][$i]->serialize(), JSON_PRETTY_PRINT);
    }
}

if ($login->createSession() == false) {
    echo "logad";
    $login->createSession();
} else {


    echo "<pre>";

    echo 'Usuário criado e logado';
    echo "</pre>";
    //echo "<pre>";
    //echo var_dump($_SESSION['logado']);
    //echo var_dump($_SESSION);
    //echo "</pre>";

    for ($i = 0; $i <= sizeof($_SESSION['logado']['carrinho']); $i++) {
        echo json_encode($_SESSION['logado']['carrinho'][$i]->serialize(), JSON_PRETTY_PRINT);
    }
}
//unset($_SESSION['logado']);
//
//echo "<pre>";
//
//echo 'Usuário deslogou';
//echo "</pre>";
//
//echo "<pre>";
////    echo var_dump($_SESSION['logado']);
//echo var_dump($_SESSION);
////
?>
