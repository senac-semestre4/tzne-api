<?php
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR.'/Dao/DaoProducts.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Product.php';
$dao = new DaoProducts;

if($dao->removeByID(46)){
   echo "DELETADO"; 
}else{
    echo "Id não encotrado";
}


?>

