<?php

//header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php'; // 

require_once ROOT_DIR.'/Dao/DaoClient.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Client.php';


$c =  new Client();

$c->setName("teste");
$c->setEmail("teste@teste");
$c->setCpf("123456788");
$c->setSex("m");
$c->setPassword(md5("1236456"));
$c->setBirthday("1000-01-01 00:00:00");
$c->setTel("12345678");
$c->setCel("12345674");
$c->setDirectmail(0);
$c->setAdressType("teste");
$c->setAdressCep("21354684");
$c->setAdressLogradouro("213132465");
$c->setAdressNumber(12);
$c->setAdressComplement("teste");
$c->setAdressDistrict("teste");
$c->setAdressCity("teste");
$c->setAdressState("teste");
$c->setStatus(0);
echo $c->serialize();


$dao = new DaoClient();

$dao->insertClient($c);

?>