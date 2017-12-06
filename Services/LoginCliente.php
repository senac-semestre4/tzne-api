<?php

header('Content-Type:  text/html; application/json'); // declara o json para a extensão do chrome funcionar. 
    
   if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
        
        $_SESSION['passouaqui'] = "aqui";
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/DaoClient.php';
require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/User.php';

$json = json_decode(file_get_contents("php://input"));

if ($_POST["username"] == null && $_POST["password"] == null) {
    echo "parametros invalidos";
} else {
    
    
//  if ($json->username == null && $json->password == null) {
//    echo "parametros invalidos";
//} else {  
    
//    $u = $json->username;
//    $p =  $json->password;
    $u = $_POST["username"];
    $p = $_POST["password"];
    //$p = $_POST["password"];


    $dao = new DaoClient();

    if ($dao->findClient($u, $p) == true) {
        
          if (!isset($_SESSION)) {
                            session_start();
       				} else {
           					 //echo"ja tem sessao";
       					 }

           $_SESSION["cliente"] = $u;
          // $_SESSION["cliente_id"] = $id;
           
           echo  json_encode(array(session_name() => session_id()));
    } else {
        echo json_encode(array('autenticado' => 'false'));
        exit;
    }
}
?>