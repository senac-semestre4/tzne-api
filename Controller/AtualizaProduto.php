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

$p->setId($json->product_id);
$p->setName($json->product_name);
$p->setModel($json->product_model);
$p->setCode($json->product_code);
$p->setSpecification($json->product_specification);
$p->setPurchase_price($json->product_purchase_price);
$p->setProfit_margin($json->product_profit_margin);
$p->setPromotional_price($json->product_promotional_price);
$p->setLength($json->product_length);
$p->setWidth($json->product_width);
$p->setHeigth($json->product_heigth);
$p->setImg_relative_url($json->product_img_relative_url);
$p->setStatus($json->product_status);
$p->setBrands_brand_id($json->brands_brand_id);
$p->setDepartaments_departament_id($json->departaments_departament_id);
$options = new ProductOpitons();

$options->setColor($json->products_color_product_id_color);
$options->setSize($json->products_size_product_id_size);
$options->setQtd($json->product_quantity);


//Cria a Dao
$dao = new DaoProducts;

//Verifica se foi atualizado
if ($dao->updateProduct($p, $options)) {
    echo "atualizado";
} else {
    echo "Não atulizou";
}
?>