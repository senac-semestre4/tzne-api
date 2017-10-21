<?php
session_start();
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
        echo "Sessão de usuário administrador criada";
        $_SESSION["admin"] = $u;
    } else {
        header('Location: /View/TestesViews/ViewLogin/telalogin.php');
        exit;
    }
}
?>