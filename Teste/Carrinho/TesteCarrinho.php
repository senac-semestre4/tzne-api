<?php

header('Content-Type:  text/html'); // declara o json para a extensão do chrome funcionar. 

/*
 * Nesse teste crio produtos e tento adicionar no 
 * carrinho, repetindo as características 
 * id cor e tam do produto, caso seja iguais não deve adicionar ao carrinho.
 * 
 */

//inicio e destruo qualquer sessão ativa
session_start();
session_destroy();
//Configurando dependências de outras classes
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR . '/Model/Login.php';
require_once ROOT_DIR . '/Model/Product.php';
require_once ROOT_DIR . '/Services/Cart.php';
require_once '../../Dao/DaoProducts.php';

$pdao1 = new Product();
$pdao2 = new Product();

$dao = new DaoProducts();
$pdao1 = $dao->listById(10);
//echo $json;

echo json_encode($pdao1->serializeProduct());
echo json_encode($pdao1->serializeOptions());

//criando e atribuindo valores para um produto
$p = new Product();
$p->setId(3);
$p->setName("p1");
$p->setModel("model");
$p->setCode(2);
$p->setSpecification("especificação");
$p->setPurchase_price(10.0);
$p->setProfit_margin(10.0);
$p->setPromotional_price(0.0);
$p->setLength(1.0);
$p->setWidth(1.0);
$p->setHeigth(1.0);
//$p->setStock_quantity(1);
$p->setImg_relative_url("sdsds");
$p->setStatus(true);
$p->setBrands_brand_id(1);
$p->setDepartaments_departament_id(1);
$p->setQtd(1);
$p->setTshirtSize("M");
$p->setTshirtColor("Azul");
////echo $p->serialize();


$p2 = new Product();
$p2->setId(3);
$p2->setName("p2");
$p2->setModel("model");
$p2->setCode(1);
$p2->setSpecification("especificação");
$p2->setPurchase_price(10.0);
$p2->setProfit_margin(10.0);
$p2->setPromotional_price(0.0);
$p2->setLength(1.0);
$p2->setWidth(1.0);
$p2->setHeigth(1.0);
//$p2->setStock_quantity(1);
$p2->setImg_relative_url("sdsds");
$p2->setStatus(true);
$p2->setBrands_brand_id(1);
$p2->setDepartaments_departament_id(1);
$p2->setQtd(1);
$p2->setTshirtSize("M");
$p2->setTshirtColor("Azul");

$p3 = new Product();
$p3->setId(4);
$p3->setName("p2");
$p3->setModel("model");
$p3->setCode(1);
$p3->setSpecification("especificação");
$p3->setPurchase_price(10.0);
$p3->setProfit_margin(10.0);
$p3->setPromotional_price(0.0);
$p3->setLength(1.0);
$p3->setWidth(1.0);
$p3->setHeigth(1.0);
//3p2->setStock_quantity(1);
$p3->setImg_relative_url("sdsds");
$p3->setStatus(true);
$p3->setBrands_brand_id(1);
$p3->setDepartaments_departament_id(1);
$p3->setQtd(1);
$p3->setTshirtSize("P");
$p3->setTshirtColor("Roxo");








if (isset($_SESSION)) {

    session_start();
    //echo "Criando sessão";
} else {
    //echo "Já existe sessão";
}
//echo "<pre>";
//            //echo var_dump($_SESSION);            
//echo "</pre>";


unset($_SESSION['sacola']);
unset($_SESSION['logado']);
unset($_SESSION['carrinho']);
unset($_SESSION['usuario']);
session_destroy();

$login = new Login("wmv", 1236456);

if ($login->createSession() == true) {
    //echo 'Sessão de usuário criada';
    //echo "<BR>";
}



$cart = new Cart;

if (array_key_exists("carrinho", $_SESSION)) {
    //echo "<BR>";
    //echo 'Carrinho já existe';
    //echo "<BR>";
} else {
    //echo "<BR>";
    if ($cart->createBag() == false){
    //echo "<BR>";
    //echo 'Sacola já existe';
    //echo "<BR>";
    }else{
        $cart->createBag();
    }
}


$cart->addProduct($p);
$cart->addProduct($p2);
$cart->addProduct($p3);
$cart->addProduct($p3);
$cart->addProduct($pdao1);

header('Content-Type:  application/json'); // declara o json para a extensão do chrome funcionar. 

//$cart->findProduct($p3);

//var_dump($_SESSION['sacola'][0]);
echo"PRIMEIRA         LISTAGEMMMMMMMMM";

$cart->listBagItems();




$cart->removeItemBag($p3);

echo"SEGUNDA         LISTAGEMMMMMMMMM";        

$cart->listBagItems();


?>
