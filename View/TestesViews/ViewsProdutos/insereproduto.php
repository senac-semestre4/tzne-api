<?php
ini_set('display_errors', 0);
/*
 * Este arquivo juntei o php e html para facilitar a motagem do teste. 
 * Esse poderá ser usado como interface para cadastro de produtos
 */

//Verifica se o post vindo do name "code", no html, está vazio, 
//se não recebe os parâmetros e tenta inserir no banco
if($_POST['code']){
    
    $path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR.'/Dao/DaoProducts.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Product.php';

$p = new Product();

$p->setName($_POST['nome']); 
$p->setModel($_POST['model']); 
$p->setCode($_POST['code']); 
$p->setSpecification($_POST['specification']); 
$p->setPurchase_price($_POST['purchase_price']); 
$p->setProfit_margin($_POST['profit_margin']); 
$p->setPromotional_price($_POST['promotional_price']); 
$p->setLength($_POST['length']); 
$p->setWidth($_POST['width']); 
$p->setHeigth($_POST['heigth']); 
$p->setStock_quantity($_POST['product_stock_quantity']); 
$p->setImg_relative_url($_POST['img_relative_url']); 
$p->setStatus($_POST['status']); 
$p->setBrands_brand_id($_POST['brands_brand_id']);
$p->setDepartaments_departament_id($_POST['departaments_departament_id']);
$p->setTshirtColor($_POST['fk_product_id_color']);
$p->setTshirtSize($_POST['fk_product_size_id']);




$dao = new DaoProducts;

$dao->insertProduct($p);


    
    
    
    
// Caso contrário mostra o  formulário para inserir o produto    
}else{ ?>


<form action="insereproduto.php" method="post">
    
    
    
            <label>Nome</label>
            <br>
            <input type="text" name="nome" value="">
            <br><br>
            <label>Modelo</label>
            <br>
            <input type="text" name="model" value="">
            <br><br>
            <label>Codigo</label>
            <br>
            <input type="text" name="code" value="">
            <br><br>
            <label>Especificação</label>
            <br>
            <input type="text" name="specification" value="Espec">
            <br><br>
            
            <label>Preço de venda</label>
            <br>
            <input type="text" name="purchase_price" value="50">
            <br><br>
            <label>Margem de lucro</label>
            <br>
            <input type="text" name="profit_margin" value="10">
            <br><br>
            <label>Preço promocional</label>
            <br>
            <input type="text" name="promotional_price" value="0">
            <br><br>
            
            <label>Comprimento</label>
            <br>
            <input type="text" name="length" value="50">
            <br><br>
            <label>Largura</label>
            <br>
            <input type="text" name="width" value="50">
            <br><br>
            <label>Altura</label>
            <br>
            <input type="text" name="heigth" value="50">
            <br><br>
            
            <label>Status</label>
            
            <select name="status">
                  <option value="1">Ativo</option>
                  <option value="0">Desativado</option>
            </select>
            <br><br>
            <label>Quantidade em estoque</label>
            <br>
            <input type="text" name="product_stock_quantity" value="">
            <br><br>
            <label>Id da marca</label>
            <br>
            <input type="text" name="brands_brand_id" value="1">
            <br><br>
            
            <label> Id do departamento</label>
            <br>
            <input type="text" name="departaments_departament_id" value="1">
            <br><br>
            <label>Id da cor</label>
            <br>
            <input type="text" name="fk_product_id_color" value="1">
            <br><br>
            <label>Id do tamanho </label>
            <br>
            <input type="text" name="fk_product_size_id" value="1">
            <br><br>
            
            <label>URL da imagem</label>
            <br>
            <input type="text" name="img_relative_url" value="urls teste">
            <br><br>
            
            <input type="submit" value="Submit">



        </form> 


<?php

}
?>