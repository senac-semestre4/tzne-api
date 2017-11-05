<?php
//header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

session_cache_limiter(false);
session_start();
//session_destroy();

require __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/Controller/ListarProdutos.php';  
require_once ROOT_DIR.'/Dao/DaoClient.php';
require_once ROOT_DIR.'/Model/Product.php';

//instancie o objeto


$app = new \Slim\Slim();
$app->config('debug', true);
//$app->response->headers->set('Content-Type', 'application/json');



$app->get('/listarota/',function() use ($app){ 
    $routes = $app->router()->getNamedRoutes(); 
    
    foreach($routes as $route){ 
        echo "tzne.com.br{$route->getPattern()}\n"; 
    } 
    exit; 
});


/*
$app->get('/hello/:name', function ($name) {
    echo "Ola, $name";
});

//defina a rota
$app->get('/', function () { 
  echo "Olá"; 
}); 
//rode a aplicação Slim 



*/


$group = $app->group('/api', function () use ($app) {

    // Library group
    $app->group('/produtos', function () use ($app) {
        
                     $app->get('/listarprodutos/departamento/:departamentid', function ($departamentid) {
                     $dao = new DaoProducts();
                     $dao->listProdDepartaments($departamentid);
                  })->setName('listarprodutos/departamento/:departamentid');

                  
                  $app->get('/listarprodutos', function () {
                    $dao = new DaoProducts();
                    $dao->listAlLProducts(0, 0);
                  })->setName('listarprodutos');

                  $app->get('/listarprodutos/:id', function ($id) {
                  $p = new Product();
                  $dao = new DaoProducts();
                  $p = $dao->listById($id);
                  $p->setOptions($p->serializeOptions());
                  echo json_encode($p->serializeProduct());
                  })->setName('listarprodutos/:id');

                  $app->get('/listarprodutos/:limit/:offset', function ($limit, $offset) {
                    $dao = new DaoProducts();
                    $dao->listAlLProducts($limit, $offset);
                    })->setName('listarprodutos/:limit/:offset');
                  
                  $app->post('/inserirproduto', function () use($app){
                    $app->redirect('/Controller/InsereProduto.php', 307);
                  })->setName('insereproduto');
                  


        });




    $app->group('/clientes', function () use ($app) {


         $app->get('/listarclientes', function () {
                        $dao = new DaoClient();

                        $dao->listAllClients();

                  })->setName('listarclientes');


                  $app->get('/listarclientes/:id', function ($id) {
                          $dao = new DaoClient();

                          $dao->listByID($id);

                  })->setName('listarclientes/:id');




 });
 
 

 $app->group('/frete', function () use ($app) {

                  $app->post('/calculafrete', function () use ($app) {
     $json = json_decode(file_get_contents("php://input"));

                      
$peso = $json->quantidade*1;
$sCepDestino = $json->sCepDestino;

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
                        

                    //$app->redirect('/Controller/RecebeDadosFrete.php', 307);
                  })->setName('frete');

        });

/*
   
 $app->get('/lista', function() {
     
     
     // $_SESSION['admin'] = "teste";
     
     
     try{
         
          if($_SESSION['admin'] !=null ){
              
              
              //$app->redirect('/View/TestesViews/ViewsProdutos/atualizaproduto.php');
                 require_once __DIR__ . '/Controller/ListarProdutos.php';  


     }
     
     
     } catch (Exception $ex) {
         //echo $_SESSION['admin'];
         

     }
    
});

*/


});






$app->get('/', function () use($app){ 

  
/*
    $routes = $app->router()->getNamedRoutes(); 
    
    foreach($routes as $route){ 
        echo "tzne.com.br{$route->getPattern()}\n"; 
    } 
    exit; 
*/

      $routes = $app->router()->getNamedRoutes();
      
    foreach($routes as $route){ 
        echo "{$route->getName()} : {$route->getPattern()}\n"; 
    } 
    exit; 
}); 


 $app->post('/teste', function () {
     
     $json = json_decode(file_get_contents("php://input"));
     
     echo json_encode($json);
});
 $app->options('/teste', function () {
     
     $json = json_decode(file_get_contents("php://input"));
          echo json_encode($json);
});

$app->run();


?>