<?php



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://ws.sandbox.pagseguro.uol.com.br/v2/sessions");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "email=karina.armiato@gmail.com&token=216FC171611C4F56AC55CFA3A64A5F8B");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);


$xml=simplexml_load_string($server_output) or die("Error: Cannot create object");



curl_close ($ch);

 print_r($xml);


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js">
	//para testar, chamar no console do navegador as seguites funções:
	    // PagSeguroDirectPayment.setSessionId('ID_DA_SESSÃO');	
	    PagSeguroDirectPayment.setSessionId();
	    PagSeguroDirectPayment.getSenderHash();
	    PagSeguroDirectPayment.getPaymentMethods({
            success: function(response){ console.log(response); },
            error: function(response){ console.log(response); },
            complete: function(response){ console.log(response); }
        });

	
</script>
</head>
<body>

</body>
</html>
