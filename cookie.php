<?php
session_start();
echo "<pre>";
echo var_dump($_COOKIE['PHPSESSID']);
echo "</pre>";

$nome = "sacola";
//$valor[] = $_SESSION['PHPSESSID'];
$valor[] = $_SESSION['sacola'];
$expira = time()+60*60*24*30;
setcookie($nome, serialize($valor), $expira);
echo "<pre>";

////var_dump($_COOKIE['sacola']);

$sacola = unserialize($_COOKIE['sacola']);

var_dump($sacola);
echo "</pre>";

?>
