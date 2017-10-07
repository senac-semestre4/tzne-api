<?php
require 'C:\xampp\htdocs\EcommercePI4\Model\SalesItem.php';

// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Set session variables


$itemVenda =  new SalesItem(1, 3, "verde", "P");
$itemVenda2 =  new SalesItem(2, 1, "vermelho", "M");
$itemVenda3 =  new SalesItem(3, 5, "amarelo", "G");

$cart =  array(); // "session"

/*
$cart[0]['id']=0;
$cart[0]['qtd']=2;
$cart[0]['tam']="m";

$cart[1]['id']=0;
$cart[1]['qtd']=3;
$cart[1]['tam']="P";
*/





array_push($cart, $itemVenda);
array_push($cart, $itemVenda2);
array_push($cart, $itemVenda3);



echo"<pre>";
echo var_dump($cart);
echo"</pre>";

echo"<pre>";
//echo $cart[0];
echo"</pre>";

/*
$_SESSION['carrinho']= array();

$_SESSION['carrinho'][1] = 10; // num 1 representa id
$_SESSION['carrinho']['qtd'] = 3; // qtd

$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo var_dump($_SESSION['carrinho']);
echo"<br>";
echo ($_SESSION['carrinho'][1]);
echo"<br>";
$_SESSION['carrinho']['qtd'] = 3; // qtd

*/
?>

</body>
</html>