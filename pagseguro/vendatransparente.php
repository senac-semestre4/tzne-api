<?php

require_once "/var/www/cloud.kwcraft.com.br/public_html/pagseguro/lib/PagSeguroLibrary/PagSeguroLibrary.php";

$paymentRequest = new PagSeguroPaymentRequest();  
$paymentRequest->addItem('0001', 'Notebook', 1, 2430.00);  
$paymentRequest->addItem('0002', 'Mochila',  1, 150.99);  

$sedexCode = PagSeguroShippingType::getCodeByType('SEDEX');  
$paymentRequest->setShippingType($sedexCode);  
$paymentRequest->setShippingAddress(  
  '01452002',  
  'Av. Brig. Faria Lima',  
  '1384',  
  'apto. 114',  
  'Jardim Paulistano',  
  'São Paulo',  
  'SP',  
  'BRA'  
);  

$paymentRequest->setSender(  
  'João Comprador',  
  'email@comprador.com.br',  
  '11',  
  '56273440',  
  'CPF',  
  '156.009.442-76'  
);  

$paymentRequest->setCurrency("BRL");  

$paymentRequest->setReference("REF123");  
  
// URL para onde o comprador será redirecionado (GET) após o fluxo de pagamento  
$paymentRequest->setRedirectUrl("http://www.lojamodelo.com.br");  
  
// URL para onde serão enviadas notificações (POST) indicando alterações no status da transação  
$paymentRequest->addParameter('notificationURL', 'http://www.lojamodelo.com.br/nas');  


$paymentRequest->addParameter('senderBornDate', '07/05/1981');  

try {  
  
  $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
  $checkoutUrl = $paymentRequest->register($credentials);  

echo $checkoutUrl;
  
} catch (PagSeguroServiceException $e) {  
    die($e->getMessage());  
}  


?>
