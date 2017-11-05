<?php
header('Content-Type:  application/json'); // declara o json para a extensão do chrome funcionar. 

$peso = $_POST['quantidade']*1;
$sCepDestino = $_POST['sCepDestino'];

	$parametros = array();
	
	// Código e senha da empresa, se você tiver contrato com os correios, se não tiver deixe vazio.
	$parametros['nCdEmpresa'] = '';
	$parametros['sDsSenha'] = '';
	
	// CEP de origem e destino. Esse parametro precisa ser numérico, sem "-" (hífen) espaços ou algo diferente de um número.
	$parametros['sCepOrigem'] = '05223070';
	$parametros['sCepDestino'] = $sCepDestino;
	
	// O peso do produto deverá ser enviado em quilogramas, leve em consideração que isso deverá incluir o peso da embalagem.
	$parametros['nVlPeso'] = $peso;
	
	// O formato tem apenas duas opções: 1 para caixa / pacote e 2 para rolo/prisma.
	$parametros['nCdFormato'] = '1';
	
	// O comprimento, altura, largura e diametro deverá ser informado em centímetros e somente números
	$parametros['nVlComprimento'] = '16';
	$parametros['nVlAltura'] = '5';
	$parametros['nVlLargura'] = '15';
	$parametros['nVlDiametro'] = '0';
	
	// Aqui você informa se quer que a encomenda deva ser entregue somente para uma determinada pessoa após confirmação por RG. Use "s" e "n".
	$parametros['sCdMaoPropria'] = 'n';
	
	// O valor declarado serve para o caso de sua encomenda extraviar, então você poderá recuperar o valor dela. Vale lembrar que o valor da encomenda interfere no valor do frete. Se não quiser declarar pode passar 0 (zero).
	$parametros['nVlValorDeclarado'] = '0';
	
	// Se você quer ser avisado sobre a entrega da encomenda. Para não avisar use "n", para avisar use "s".
	$parametros['sCdAvisoRecebimento'] = 'n';
	
	// Formato no qual a consulta será retornada, podendo ser: Popup  mostra uma janela pop-up | URL  envia os dados via post para a URL informada | XML  Retorna a resposta em XML
	$parametros['StrRetorno'] = 'xml';
	
	// Código do Serviço, pode ser apenas um ou mais. Para mais de um apenas separe por virgula.
	$parametros['nCdServico'] = '41106';
	
	
	$parametros = http_build_query($parametros);
	$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

	$curl = curl_init($url.'?'.$parametros);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$dados = curl_exec($curl);
	$dados = simplexml_load_string($dados);
	if(!$dados->Erro == 7){
	echo json_encode($dados);

//	echo $dados->MsgErro;
	}else{
		//Além da mensagem podemos criar um método para enviar uma notificação por email para informar o administrador do erro
		echo "Sistema de consulta de frete indisponível";

	}
/*	
	foreach($dados->cServico as $linhas) {
		if($linhas->Erro == 0||$linhas->Erro == '011') {
			echo 'Tipo de envio: '.$linhas->Codigo.' - PAC </br>';
			echo 'Valor do frete: '. $linhas->Valor .'</br>';
			echo 'Prazo de entrega: '.$linhas->PrazoEntrega.' Dias </br>';
			echo $linhas->MsgErro;
		}else  {
		echo $linhas->MsgErro .'<br>';
		}

	//	echo '<hr>';
	}
*/


//echo var_dump($dados);
?>
