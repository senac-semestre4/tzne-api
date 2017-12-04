<?php
   if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/DaoUser.php';
require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/User.php';

if ($_POST["username"] == null && $_POST["password"] == null) {
    echo "parametros invalidos";
} else {
    $u = $_POST["username"];
    $p = $_POST["password"];
    //$p = $_POST["password"];


    $dao = new DaoUser;

    if ($dao->findUser($u, $p) == true) {
        
         if (!isset($_SESSION)) {
                            session_start();
       				} else {
           					 //echo"ja tem sessao";
       					 }
                                         
                   $_SESSION["admin"] = $u;
                //echo "Sessão de usuário administrador criada " .$_SESSION["admin"] ;
                header('Location: /admin/insereproduto');
    } else {
       header('Location: /admin');
        exit;
    }
}
?>