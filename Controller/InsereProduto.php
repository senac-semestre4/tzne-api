<?php

ini_set('display_errors', 1);
/*
 * Este arquivo juntei o php e html para facilitar a motagem do teste. 
 * Esse poderá ser usado como interface para cadastro de produtos
 */

//Verifica se o post vindo do name "code", no html, está vazio, 
//se não recebe os parâmetros e tenta inserir no banco
//$url = "http://tzne.com.br/View/TestesViews/ViewsProdutos/insereproduto.php";

$url = "http://tzne.kwcraft.com.br/View/TestesViews/ViewsProdutos/insereproduto.php";
if($_POST['code']){
    
    $path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR.'/Dao/DaoProducts.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Product.php';
require_once ROOT_DIR.'/validacao.php';


$p = new Product();
$p->setId(null);
$p->setName($_POST['name']); 
$p->setModel($_POST['model']); 
$p->setModel($_POST['description']); 
$p->setCode($_POST['code']); 
$p->setSpecification($_POST['specification']); 
$p->setPurchase_price($_POST['purchase_price']); 
$p->setSalePrice($_POST['sale_price']); 
$p->setProfit_margin($_POST['profit_margin']); 
$p->setPromotional_price($_POST['promotional_price']); 
$p->setLength($_POST['length']); 
$p->setWidth($_POST['width']); 
$p->setHeigth($_POST['heigth']); 
$p->setImg_relative_url($_POST['img_relative_url']); 
$p->setStatus($_POST['status']); 
$p->setBrands_brand_id($_POST['brands_brand_id']);
$p->setDepartaments_departament_id($_POST['departaments_departament_id']);

$arrayOptions =  array();

$options = new ProductOpitons();
$options->setProductQuantity($_POST['product_stock_quantity']);
$options->setSize($_POST['idsize']);
$options->setColor($_POST['idcolor']);


$arrayOptions[] = $options;

$dao = new DaoProducts;

$dao->insertProduct($p, $arrayOptions);

//header("Location: ".$url);
//echo "Inserido";
    
    
    
    
// Caso contrário mostra o  formulário para inserir o produto    
}else{ 

    echo json_encode('Erro : erro');
    
}
?>
