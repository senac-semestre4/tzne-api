<?php
   if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/DaoClient.php';
require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/User.php';

if ($_POST["username"] == null && $_POST["password"] == null) {
    echo "parametros invalidos";
} else {
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
           
           echo "Sessão de cliente criada ". $_SESSION["cliente"];
    } else {
        header('Location: /View/TestesViews/ViewLogin/telalogin.php');
        exit;
    }
}
?>