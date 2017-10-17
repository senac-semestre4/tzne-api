<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/DaoUser.php';
require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/User.php';

if($_POST["username"] == null && $_POST["password"] == null){
    echo "parametros invalidos";
}else{
    $u = $_POST["username"];
    $p = password_hash($_POST["password"], PASSWORD_DEFAULT);
   
        
$dao = new DaoUser;
$user = new User($u, $p);

if($dao->insertUser($user) == true){
        echo "cadastrado";
}else{
	echo "erro";
}
      
}


//$hash = password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
//
//if (password_verify('rasmuslerdorf', $hash)) {
//    echo 'Password is valid!';
//} else {
//    echo 'Invalid password.';
//}




?>