<?php
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 



$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR."/Dao/MysqlConn.php";
require_once ROOT_DIR."/Model/Login.php";


$login = new Login("w", 123456);

$login->createSession($login);

echo var_dump($_SESSION['logado']);


?>