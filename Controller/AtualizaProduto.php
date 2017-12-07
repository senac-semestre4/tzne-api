<?php

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/DaoProducts.php';
require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/Product.php';

//Recebe o Json enviado pelo form
$json = json_decode(file_get_contents("php://input"));


//Cria o produto, recebendo os names do produto enviado como Objeto
$p = new Product();

$p->setId(null);
			$p->setId($_POST['product_id']);
            $p->setName($_POST['name']);
            $p->setModel($_POST['model']);
            $p->setDescription($_POST['description']);
            $p->setCode($_POST['code']);
            $p->setSpecification($_POST['specification']);
            $p->setPurchase_price($_POST['purchase_price']);
            $p->setSalePrice($_POST['sale_price']);
            $p->setProfit_margin($_POST['profit_margin']);
            $p->setPromotional_price($_POST['promotional_price']);
            $p->setLength($_POST['length']);
            $p->setWidth($_POST['width']);
            $p->setHeigth($_POST['heigth']);
            $p->setStatus($_POST['status']);
            $p->setBrands_brand_id($_POST['brands_brand_id']);
            $p->setDepartaments_departament_id($_POST['departaments_departament_id']);
           
            $options = new ProductOpitons();
            $options->setProductQuantity($_POST['product_stock_quantity']);
            $options->setSize($_POST['idsize']);
            $options->setColor($_POST['idcolor']);
           

/*    echo "<pre>";
    echo var_dump($p);
    echo "<pre>";
    
    echo "<pre>";
    echo var_dump($options);
    echo "<pre>";*/
//Cria a Dao
$dao = new DaoProducts;

//Verifica se foi atualizado
if ($dao->updateProduct($p, $options)) {
    echo "atualizado";
} else {
    echo "Não atulizou";
}
?>