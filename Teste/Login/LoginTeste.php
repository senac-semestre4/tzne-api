<?php

header('Content-Type:  text/html; application/json'); // declara o json para a extensão do chrome funcionar. 
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






if (isset($_SESSION)) {

    session_start();
    echo "Criando sessão";
} else {
    echo "Já existe sessão";
}
echo "<pre>";
//            echo var_dump($_SESSION);            
echo "</pre>";


unset($_SESSION['sacola']);
unset($_SESSION['logado']);
unset($_SESSION['carrinho']);
unset($_SESSION['usuario']);
session_destroy();

$login = new Login("wmv", 1236456);

if ($login->createSession() == true) {
    echo 'Sessão de usuário criada';
    echo "<BR>";
}



$cart = new Cart;

if (array_key_exists("carrinho", $_SESSION)) {
    echo "<BR>";
    echo 'Carrinho já existe';
    echo "<BR>";
} else {
    echo "<BR>";
    if ($cart->createBag() == false){
    echo "<BR>";
    echo 'Sacola já existe';
    echo "<BR>";
    }else{
        $cart->createBag();
    }
}

$cart->addProduct($p);
$cart->addProduct($p2);
$cart->addProduct($p2);

if ($cart->listCartItems() == false) {
    echo 'False';
} else {
    echo "<br>";
    echo 'Listagem feita';
}

    echo "<br>";
    echo "<pre>";
   // echo var_dump($_SESSION['logado']['carrinho']);
    echo "</pre>";
    
          echo "<br>";
                echo "tam do vet " . sizeof($_SESSION['sacola']);
                echo "<br>";
                
    
                $cart->listCartItems();
                

?>
