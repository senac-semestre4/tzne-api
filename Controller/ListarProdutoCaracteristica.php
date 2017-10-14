<?php
header('Content-Type:  text/html; application/json'); // declara o json para a extensão do chrome funcionar. 
/**
 * Description of Cart
 *
 * @author Willian Vieira
 */
$path = $_SERVER['DOCUMENT_ROOT'];

require_once $path . '/Constants.php';
require_once ROOT_DIR . '/Model/Product.php';
require_once ROOT_DIR .'/Dao/DaoProducts.php';


$codigo = $_POST['codigo'];
$idcor = $_POST['idcor'];
$idtam = $_POST['idtam'];



function get_numeric($v1,$v2,$v3) { 
  if (is_numeric($v1) && is_numeric($v2) && is_numeric($v3)) { 
      return true;; 
  } else {
      return false;
  }
  
} 

if(get_numeric($codigo, $idcor, $idtam)){
    
    $dao = new DaoProducts();
    $dao->listProductByCaracteristics($codigo, $idcor, $idtam);
}else{
    echo "parametros invalidos";
}

//$dao->listProductByCaracteristics(null, null, null);


?>
