<?php 
$ch = curl_init();
// informar URL e outras funções ao CURL
curl_setopt($ch, CURLOPT_URL, "https://ws.pagseguro.uol.com.br/v3/transactions/07C1CD23-EDCB-41B6-99F1-862212DC5D9B?email=karina.armiato@gmail.com&token=66359A41BD1641078500450E3E56A983");
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




?>