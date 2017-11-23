<?php



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://ws.sandbox.pagseguro.uol.com.br/v2/transactions?initialDate=2017-11-01T00:00&finalDate=2017-11-16T00:00&page=1&maxPageResults=100&email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B");
//curl_setopt($ch, CURLOPT_POST, 0);
//curl_setopt($ch, CURLOPT_POSTFIELDS,
  //          "?initialDate=2011-01-01T00:00&finalDate=2011-01-28T00:00&page=1&maxPageResults=100&email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);


$xml=simplexml_load_string($server_output) or die("Error: Cannot create object");



curl_close ($ch);

 print_r($xml);


?>
