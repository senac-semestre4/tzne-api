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


//Recebendo os dados via POST
$codigo = $_POST['code'];
$idcor = $_POST['fk_product_id_color'];
$idtam = $_POST['fk_product_size_id'];

//Se todos os campos forme números executa a Dao
if(get_numeric($codigo, $idcor, $idtam)){
    
    $dao = new DaoProducts();
    
    if(!$dao->listProductByCaracteristics($codigo, $idcor, $idtam)){
        echo "Produto não encontrado";
    }
    
}else{
    echo "parametros invalidos";
}

//$dao->listProductByCaracteristics(null, null, null);


//Funlção que verifica se os dados passados são todos números
function get_numeric($v1,$v2,$v3) { 
  if (is_numeric($v1) && is_numeric($v2) && is_numeric($v3)) { 
      return true;; 
  } else {
      return false;
  }
  
} 
?>
