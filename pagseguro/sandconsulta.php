<?php 



$ch = curl_init();
// informar URL e outras funções ao CURL
curl_setopt($ch, CURLOPT_URL, "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/40DF245B-994D-4D1F-BEC4-A3BBFDC779EF?email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B");

/* Teste de consulta por data 
https://ws.sandbox.pagseguro.uol.com.br/v2/transactions?initialDate=2017-07-01T00:00&finalDate=2017-07-31T00:00&page=1&maxPageResults=100&email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B

*/

curl_setopt($curl, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset=ISO-8859-1'));


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Acessar a URL e retornar a saída
$output = curl_exec($ch);
// liberar
curl_close($ch);
// Substituir ‘Google’ por ‘PHP Curl’
$output = str_replace('Google', 'PHP Curl', $output);
// Imprimir a saída
//echo $output;

$xml=simplexml_load_string($output) or die("Error: Cannot create object");
echo '<pre>';
print_r($xml);
echo '</pre>';

echo strval($xml->error->code);
echo '<br>';
echo strval($xml->error->message);











/*https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/?email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B
*/

/*
$ch = curl_init();
// informar URL e outras funções ao CURL

curl_setopt($ch, CURLOPT_URL, "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/40DF245B-994D-4D1F-BEC4-A3BBFDC779EF?email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B");


curl_setopt($ch, CURLOPT_POST, true);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Acessar a URL e retornar a saída
$output = curl_exec($ch);
// liberar
curl_close($ch);
// Substituir ‘Google’ por ‘PHP Curl’
//$output = str_replace('Google', 'PHP Curl', $output);
// Imprimir a saída
echo $output;

$xml=simplexml_load_string($output) or die("Error: Cannot create object");
echo '<pre>';
print_r($xml);
echo '<pre>';

/*echo echo '</pre>';strval($xml->error->code);
echo '<br>';
echo strval($xml->error->message);

*/


/*
curl https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/ -d\

"email=suporte@lojamodelo.com.br\
&token=57BE455F4EC148E5A54D9BB91C5AC12C\
&currency=BRL\
&itemId1=0001\
&itemDescription1=Produto PagSeguroI\
&itemAmount1=99999.99\
&itemQuantity1=1\
&itemWeight1=1000\
&itemId2=0002\
&itemDescription2=Produto PagSeguroII\
&itemAmount2=99999.98\
&itemQuantity2=2\
&itemWeight2=750\
&reference=REF1234\
&senderName=Jose Comprador\
&senderAreaCode=99\
&senderPhone=99999999\
&senderEmail=comprador@uol.com.br\
&shippingType=1\
&shippingAddressStreet=Av. PagSeguro\
&shippingAddressNumber=9999\
&shippingAddressComplement=99o andar\
&shippingAddressDistrict=Jardim Internet\
&shippingAddressPostalCode=99999999\
&shippingAddressCity=Cidade Exemplo\
&shippingAddressState=SP\
&shippingAddressCountry=ATA"

*/


?>