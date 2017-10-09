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

$dao = new DaoProducts();


$dao->listAlLProducts();




?>
