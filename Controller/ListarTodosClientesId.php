<?php

if($_POST['idcliente']){
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php'; // 

require_once ROOT_DIR.'/Dao/DaoClient.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Client.php';
$dao = new DaoClient();

$dao->listByID($_POST['idcliente']);
    
}else{
    echo "parametros invalidos";
}