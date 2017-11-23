<?php

//header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 
//session_cache_limiter(false);
//
//session_start();
//unset($_SESSION);
//session_destroy();

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Controller/ListarProdutos.php';
require_once ROOT_DIR . '/Dao/DaoClient.php';
require_once ROOT_DIR . '/Model/Product.php';
require_once ROOT_DIR . '/Dao/DaoProducts.php';
require_once ROOT_DIR . '/Services/Cart.php';
require_once ROOT_DIR . '/Model/Sale.php';
require_once ROOT_DIR . '/Model/SalesItens.php';
require_once ROOT_DIR . '/Dao/DaoSale.php';

require_once ROOT_DIR . '/Model/HelpDesk.php';
require_once ROOT_DIR . '/Dao/DaoHelpdesk.php';

//instancie o objeto


$app = new \Slim\Slim();
$app->config('debug', true);
//$app->response->headers->set('Content-Type', 'application/json');


//Lista todoas as rotas
$app->get('/listarota/', function() use ($app) {
    $routes = $app->router()->getNamedRoutes();

    foreach ($routes as $route) {
        echo "tzne.kwcraft.com.br{$route->getPattern()}\n\n";
    }
    exit;
});





//Rota agrupada /API
$group = $app->group('/api', function () use ($app) {

    //*********************GRUPO VENDA***************************************
    $app->group('/venda', function () use ($app) {

        //Insere a venda recebendo parametros do front
        $app->get('/inserevendateste', function () {
            //Configurando o horário para a inserção no banco
            date_default_timezone_set("America/Sao_Paulo");

            //Simula dados da venda
            $amount = 55;
            $clientClientId = 1;
            $discount = 0;
            $numberPlots = 2;
            $totalPartial = 55;
            $typeFreight = "correios";
            $valueFreight = 15;


            //Simula item de venda genérico
            $productProductHasId = 178;
            $quantity = 2;
            $subtotal = 115;
            $date = date('Y-m-d H:i:s');
            $comment = "Pedido aguardando aprovação.";

            //Instancia o objeto venda
            $sale = new Sale();
            //instancia o objeto de venda 1
            $saleItem = new SalesItens();
            //instancia o objeto de venda 2
            $saleItem1 = new SalesItens();
            
            //Seta os valores da venda
            $sale->setAmount($amount);
            $sale->setClientClientId($clientClientId);
            $sale->setDiscount($discount);
            $sale->setNumberPlots($numberPlots);
            $sale->setTotalPartial($totalPartial);
            $sale->setTypeFreight($typeFreight);
            $sale->setValueFreight($valueFreight);


            //Seta o primeiro item
            $saleItem->setProductProductHasId($productProductHasId);
            $saleItem->setQuantity($quantity);
            $saleItem->setSubtotal($subtotal);
            $saleItem->setDate($date);
            $saleItem->setComment($comment);
            //Seta o segundo item
            $saleItem1->setProductProductHasId($productProductHasId);
            $saleItem1->setQuantity($quantity);
            $saleItem1->setSubtotal($subtotal);
            $saleItem1->setDate($date);
            $saleItem1->setComment("Pedido aguardando aprovação.");

            //Seta os "itens de venda 1 e 2" na venda
            $sale->setSalesItens($saleItem);
            $sale->setSalesItens($saleItem1);
            //Instancia a DAOVenda
            $dao = new DaoSale(); 
            //Executa a ação no banco para inserir a venda
            $dao->insertSale($sale);
            
        })->setName('inserevendateste');
        
        $app->post('/inserevenda', function () use ($app){
            //Configurando o horário para a inserção no banco
            //$app->response->headers->set('Content-Type', 'text/html');
            date_default_timezone_set("America/Sao_Paulo");
            //header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 
      
            
        

            //Simula item de venda genérico
            $productProductHasId = 178;
            $quantity = 2;
            $subtotal = 115;
            
            $date = date('Y-m-d H:i:s');
            $comment = "Pedido aguardando aprovação.";

            //Instancia o objeto venda
            $sale = new Sale();
            //instancia o objeto de venda 1
           
            $saleItem = new SalesItens();
           
            
            
            
       
            $objson = $_POST['json'];
            
            
            
            //Objeto venda com dois produtos
//            $objson ='{"client_client_id":1,"total_partial":230,"amount":115,"discount":0,"type_freight":"correios","value_freight":16,"number_plots":2, "itens":
//                      [{"product_product_has_id":153,"product_name": "Camiseta Homem Aranha","unit_price":57.50,"quantity":6,"subtotal":115},{"product_product_has_id":178,"product_name": "Camiseta Homem Aranha","unit_price":57.50,"quantity":2,"subtotal":115}]}';

        
           // $a= json_encode(json_decode($objson, JSON_PRETTY_PRINT));
            //Decodifica string json para objeto php
            $b= json_decode($objson);
            //$b= $objson;
            
            //Seta os valores da venda recebidos pelo objeto JSON
            $sale->setAmount($b->{'amount'});
            $sale->setClientClientId($b->{'client_client_id'});
            $sale->setDiscount($b->{'discount'});
            $sale->setNumberPlots($b->{'number_plots'});
            $sale->setTotalPartial($b->{'total_partial'});
            $sale->setTypeFreight($b->{'type_freight'});
            $sale->setValueFreight($b->{'value_freight'});

            
             $dao = new DaoProducts();
            //Laço de repetição que irá popular os itens de venda, na venda
            for ($i = 0; $i <sizeof($b->itens);$i++){
                $p = new Product();
                $dao = new DaoProducts();
                $p = $dao->listByasId($b->{'itens'}[$i]->product_product_has_id);
                $p->setOptions($p->serializeOptions());
               
                if($p->getProductQuantity() < $b->{'itens'}[$i]->quantity){
                    $app->response->headers->set('Content-Type', 'application/json');
                    $erro = substr_replace(json_encode($b), '"quantidadeAlterada":true,', 1,0);
                    $str = preg_replace( "/\"quantity\":".$b->{'itens'}[$i]->quantity."/" , "\"quantity\":".$p->getProductQuantity(), $erro);
                    //echo json_encode($objson, JSON_PRETTY_PRINT);
                     $app->response->headers('Access-Control-Allow-Origin', 'http://localhost:8000');
                     $app->response->headers('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
                     $app->response->headers('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                     
                     
                     $app->response->setBody($str);
                    //echo $erro;
                    break;
                }else{
                // para cada laço um novo item, para ser adicionado na venda
                $saleItem = new SalesItens();
                //Passando os parametros do objeto obtido através do json
                $saleItem->setProductProductHasId($b->{'itens'}[$i]->product_product_has_id);
                $saleItem->setQuantity($b->{'itens'}[$i]->quantity);
                $saleItem->setSubtotal($b->{'itens'}[$i]->subtotal);
                $saleItem->setDate($date);
                $saleItem->setComment($comment);
                //Como SaleItem é private, temos que passar o serialize dela para Sale, caso contrário não será 
                //exibido
                $sale->setSalesItens($saleItem->serializeSaleItens());
                }
            }
           //Mostra a venda 
            //echo json_encode($sale->serializeSale());
         
            
            /*
             * Bloco que mostra o objeto venda
          echo"<pre>";  
          echo var_dump($sale);
          echo"</pre>";  
           */
            

            
            //Instancia a DAOVenda
            $dao = new DaoSale(); 
            //Executa a ação no banco para inserir a venda
            $dao->insertSale($sale);
            
            
            //echo $objson;
        })->setName('inserevenda');
        
        
        //lista todos os pedidos
        $app->get('/listarpedidos', function () {
                $dao = new DaoSale();
                
                $json = $dao->listSalesStatus();
                
                $obj = json_decode($json);
 
            for($i = 0; $i < sizeof($obj); $i++){
                        
                    echo"
                        <table border=\"1\">
                        <form id ='{$obj[$i]->sale_id}' action = \"/api/venda/atualizastatuspedido\" method =\"POST\">
                                
                                
                        <tr>
                                    <th>id veda</th>
                                    <th>id cliente</th>
                                    <th>total</th>
                                    <th>parcelas</th>
                                    <th>Nome status</th>
                                    <th>status</th>
                        </tr>
                                <tr>
                                        <input type = \"hidden\" name=\"saleid\" value =\"{$obj[$i]->sale_id}\">
                                        <td>{$obj[$i]->sale_id}</td>
                                        <td>{$obj[$i]->client_client_id}</td>
                                        <td>{$obj[$i]->amount}</td>
                                        <td>{$obj[$i]->number_plots}</td>
                                        <td>{$obj[$i]->name}</td>
                                        <td><input type=\"number\" name=\"status\" value=\"{$obj[$i]->order_status_order_status_id}\"></td>
                                        <td><input type=\"submit\" name=\"atualizar\" value=\"Atualizar\"></td>
                                </tr>
                                
                        </form>
                   <table>   
                   ";
                }
                    //echo "</table>";

               // echo "</tr>";
                
                
                //echo $json;
                
                
                
        })->setName('listarpedidos');
        
        $app->post('/atualizastatuspedido', function () {
            $dao = new DaoSale();
            $dao->updateStatusSale(intval($_POST['saleid']), intval($_POST['status']));
            
        })->setName('atualizastatuspedido');
        
        
        //Atualiza o status do pedido
        $app->get('/atualizastatuspedido/:orderstatusid/:salessaleid', function ($orderstatusid, $salessaleid) {
                $dao = new DaoSale();
                
                if($dao->updateStatusSale($orderstatusid, $salessaleid)){
                    $json = "{'atualizado':'true'}";
                    echo json_encode($json);
                }else{
                    $json = "{'atauluzado':'false'}";
                    echo json_encode($json);
                }
              })->setName('atualizastatuspedidoget');
              
              
              
    });







    //*******************************GRUPO CARRINHO***************************** 
    $app->group('/carrinho', function () use ($app) {
        
        //Adiciona produto ao carrinho
        $app->get('/addprodcarrinho/:id/:cor/:tam/:qtd', function ($id, $cor, $tam, $qtd) use($app) {

            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }

            $carrinho = new Cart();
            $p = new Product();
            $options = new ProductOpitons();
            $dao = new DaoProducts();
            //$p = $dao->listProductByCaracteristics($_POST['idproduct'], $_POST['idcolor'], $_POST['idsize']);


            if ($p = $dao->listProductByCaracteristics($id, $cor, $tam)) {

                $p->setQtd($qtd);


                //echo var_dump($_SESSION['sacola']);
                $carrinho->addProduct($p);
                echo json_encode($p->serializeProduct());

                //echo var_dump($p);
            } else {
                echo 'Produto não encontrado';
            }
        })->setName('addprodcarrinho');
        
        //Remove produto do carrinho
        $app->get('/removeprodcarrinho/:id/:cor/:tam/', function ($id, $cor, $tam) use($app) {

            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }

            $carrinho = new Cart();
            $p = new Product();
            $dao = new DaoProducts();
            //$p = $dao->listProductByCaracteristics($_POST['idproduct'], $_POST['idcolor'], $_POST['idsize']);               

            if ($p = $dao->listProductByCaracteristics($id, $cor, $tam)) {
                // echo $_SESSION['sacola'][0]->getId();
                //echo $p->getId();
                //echo var_dump($_SESSION['sacola']);
                $pos = $carrinho->removeItemBag($id, $cor, $tam);
                //echo json_encode($p->serializeProduct());
                echo $pos;
                //echo var_dump($p);
            } else {
                echo 'Produto não encontrado';
            }
        })->setName('removeprodcarrinho');

        //Lista produtos do carrinho
        $app->get('/listarcarrinho', function () use($app) {

            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }

            $carrinho = new Cart();
            //echo var_dump($_SESSION['sacola']);
            $carrinho->listBagItems();
        })->setName('listarcarrinho');
    });

//************************GRUPO PRODUTOS****************************************
    $app->group('/produtos', function () use ($app) {
        //Lista produtos pelo id do departamente
        $app->get('/listarprodutos/departamento/:departamentid', function ($departamentid) {
            $dao = new DaoProducts();
            $dao->listProdDepartaments($departamentid);
        })->setName('listarprodutos/departamento/:departamentid');

        //Listar produtos
        $app->get('/listarprodutos', function () {
            $dao = new DaoProducts();
            $dao->listAlLProducts(0, 0);
        })->setName('listarprodutos');

        //Listar produtos pelo id
        $app->get('/listarprodutos/:id', function ($id) {
            $p = new Product();
            $dao = new DaoProducts();
            $p = $dao->listById($id);
            $p->setOptions($p->serializeOptions());
            echo json_encode($p->serializeProduct());
        })->setName('listarprodutos/:id');

        //Listar produtos com limit e offset
        $app->get('/listarprodutos/:limit/:offset', function ($limit, $offset) {
            $dao = new DaoProducts();
            $dao->listAlLProducts($limit, $offset);
        })->setName('listarprodutos/:limit/:offset');
        //Inserir produto redireciona para a controller que insere

        $app->post('/inserirproduto', function () use($app) {
            $app->redirect('/Controller/InsereProduto.php', 307);
        })->setName('insereproduto');
    });
	
        $app->get('/listarprodutoscaracteristica/:id/:cor/:tam', function ($id,$cor,$tam) {
            $p = new Product();
            $dao = new DaoProducts();
            $p = $dao->listProductByCaracteristics($id,$cor,$tam);
            echo json_encode($p->serializeProduct());
        })->setName('/listarprodutoscaracteristica');

//********************GRUPO CLIENTES**************************************
    $app->group('/clientes', function () use ($app) {

        //Lista clientes
        $app->get('/listarclientes', function () {
            $dao = new DaoClient();

            $dao->listAllClients();
        })->setName('listarclientes');

        //Lista clientes por id
        $app->get('/listarclientes/:id', function ($id) {
            $dao = new DaoClient();

            $dao->listByID($id);
        })->setName('listarclientes/:id');
    });


//***************GRUPO FRETE*********************
    $app->group('/frete', function () use ($app) {
        //Calcula o frete recebendo CEP e quantidade de produto
        $app->post('/calculafrete', function () use ($app) {
            $json = json_decode(file_get_contents("php://input"));


//$peso = $json->quantidade*1;
//$sCepDestino = $json->sCepDestino;

            $peso = $_POST['quantidade'] * 1;
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

            $curl = curl_init($url . '?' . $parametros);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $dados = curl_exec($curl);
            $dados = simplexml_load_string($dados);
            //Erro 7 = indisponibilidade do sistema correio
            if (!$dados->Erro == 7) {

                echo json_encode($dados, JSON_PRETTY_PRINT);

            //	echo $dados->MsgErro;
            } else {
                //Além da mensagem podemos criar um método para enviar uma notificação por email para informar o administrador do erro
                echo "Sistema de consulta de frete indisponível";
            }

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






$app->get('/', function () use($app) {


    /*
      $routes = $app->router()->getNamedRoutes();

      foreach($routes as $route){
      echo "tzne.com.br{$route->getPattern()}\n";
      }
      exit;
     */

    $routes = $app->router()->getNamedRoutes();

    foreach ($routes as $route) {
        echo "{$route->getName()} : {$route->getPattern()}<br>";
    }
    exit;
});




//*********FORMULÁRIO DE CONTATO********************************


$app->post('/contato', function () {

    error_reporting(0);
    /* $mailer = new PHPMailer();
      echo '<pre>';
      echo  var_dump( get_object_vars($mailer));
      echo '</pre>';
     */

    
     
    
    
    

    If (isset($_POST['txtemail'])) {
        require_once ROOT_DIR . '/View/Mailer/class.phpmailer.php';

        
        
        $mailer = new PHPMailer();
        $nome = $_POST['txtnome'];
        $contato = $_POST['txtemail'];
        $tel = $_POST['txttel'];
        $assunto = $_POST['txtass'];
        
        
        
        $mensagem = "DE: " . $contato . "\nTel: ".$tel."\nMensagem:\n\n" . $_POST['txtmsg'];
        
        $h = new HelpDesk();
        $h->setClientName($nome);
        $h->setEmail($contato);
        $h->setTel($tel);
        $h->setShortDescription($assunto);
        $h->setProbReported($_POST['txtmsg']);
        
        
        
        $dao = new DaoHelpdesk();
        $json;
        if($dao->createProtocol($h)){
                        $json = "{'protocoloinserido':'true'}";
            //echo json_encode($json);
        }else{
                        $json = "{'protocoloinserido':'false'}";
            //echo json_encode($json);
        }
        
        
        
        
        
        $mailer->IsSMTP();
        $mailer->SMTPDebug = 0;
        $mailer->Port = 465; //Indica a porta de conexão para a saída de e-mails
        $mailer->Host = 'smtp.gmail.com'; //smtp.dominio.com.br
        $mailer->SMTPAuth = true; //define se haverá ou não autenticação no SMTP ssl://smtp.googlemail.com
        $mailer->SMTPSecure = 'ssl';
        $mailer->Username = 'contatotzne@gmail.com'; //Informe o e-mai o completo
        $mailer->Password = 'contatotzne123456'; //Senha da caixa postal
        $mailer->FromName = $assunto; //Nome que será exibido para o destinatário
        $mailer->From = 'contatotzne@gmail.com'; //Obrigatório ser a mesma caixa postal indicada em "username"
        $mailer->AddAddress(/* $destino, */'contatotzne@gmail.com'); //Destinatários
        $mailer->Subject = $assunto;
        $mailer->Body = $contato;
        $mailer->Body = $mensagem;
        $mailer->Send();


        
        

        
        header('Content-Type: application/json');
        $myObj->status = "enviada";

        $json .= "{'status':'enviada'}";
        $myJSON = json_encode($myObj, JSON_PRETTY_PRINT);

        echo json_encode($json);
    } else {
        error_reporting(1);
    }
});

$app->get('/listarprotocolos', function () {
    
    $dao = new DaoHelpdesk();
    
    $obj = json_decode($dao->listProcotols());
           
    //echo var_dump($obj);
    
    
    for($i = 0; $i < sizeof($obj); $i++){
                        
                    echo"
                        <table border=\"1\">
                        <form id ='{$obj[$i]->id_protocol}' action = \"/atualizaprotocolos\" method =\"POST\">
                                
                                
                        <tr>
                                    <th>id_protocol</th>
                                    <th>client_name</th>
                                    <th>email</th>
                                    <th>tel</th>
                                    <th>short_description</th>
                                    <th>prob_reported</th>

                        </tr>
                                <tr>
                                <tr>
                                        <input type = \"hidden\" name=\"id_protocol\" value =\"{$obj[$i]->id_protocol}\">
                                        <td>{$obj[$i]->id_protocol}</td>
                                        <td>{$obj[$i]->client_name}</td>
                                        <td>{$obj[$i]->email}</td>
                                        <td>{$obj[$i]->tel}</td>
                                        <td>{$obj[$i]->short_description}</td>
                                        <td><textarea disabled rows=\"4\" cols=\"50\" name=\"prob_reported\" value=\"\">{$obj[$i]->prob_reported}</textarea></td>
                                   </tr>
                                   
                                   
                         <tr>
                                    <th>solotion</th>
                                    <th>protocol_status</th>
                                    <th>status_name</th>
                                    <th>creation_date</th>
                                    <th>resolved_by</th>
                        </tr>

                                   <tr>
                                        <td><textarea  rows=\"4\" cols=\"50\" name=\"solotion\"  value=\"\">{$obj[$i]->solotion}</textarea></td>
                                        <td><input type=\"number\" name=\"protocol_status\" value=\"{$obj[$i]->protocol_status}\"></td>
                                        <td>{$obj[$i]->name_status}</td>
                                        <td>{$obj[$i]->creation_date}</td>
                                        <td><input type=\"text\" name=\"resolved_by\" value=\"{$obj[$i]->resolved_by}\"></td>                                                                                   
                                        <td><input type=\"submit\" name=\"atualizar\" value=\"Atualizar\"></td>
                                </tr>
                                </tr>
                                <br>
                        </form>
                   <table>   
                   ";
                }
    
    
})->setName('listaprotocolos');


$app->post('/atualizaprotocolos', function () {
        $dao = new DaoHelpdesk();
        /*echo var_dump(intval($_POST['id_protocol']));
        echo var_dump(intval($_POST['protocol_status']));
        echo var_dump($_POST['resolved_by']);
        echo var_dump($_POST['solotion']);*/
        
        $dao->updateProtocol(
                intval($_POST['id_protocol']), 
                intval($_POST['protocol_status']), 
                $_POST['resolved_by'], 
                $_POST['solotion']);
   
   
    
})->setName('atualizaprotocolos');




//************************Testes**************************************

/*
Para testar a venda faça um get e guarde o resultado em "a":

exemplo de preencimento de 'a'

 var a;         var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                 a =  console.log(JSON.parse(xhttp.responseText));
		 a =  JSON.parse(xhttp.responseText);

                }
            };
            xhttp.open("GET", "http://tzne.kwcraft.com.br/escrevendo.json", true);
            xhttp.send();


Feito isso faça o post de "a", na url, conforme abaixo:
var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                  console.log(JSON.parse(xhttp.responseText));
                }
            };
            xhttp.open("POST", "http://tzne.kwcraft.com.br/api/venda/inserevenda", true);
			xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


            xhttp.send("json="+JSON.stringify(a));

  */


$app->post('/teste', function () {

    $json = json_decode(file_get_contents("php://input"));

    echo json_encode($json);
});

$app->get('/testejson', function () {
    $myArr = array("John", "Mary", "Peter", "Sally");

    $myJSON = json_encode($myArr);

    echo $myJSON;
});


$app->options('/teste', function () {

    $json = json_decode(file_get_contents("php://input"));
    echo json_encode($json);
});



$authenticateForRole = function ( $role = 'member' ) {
    return function () use ( $role ) {
        $user = User::fetchFromDatabaseSomehow();
        if ( $user->belongsToRole($role) === false ) {
            $app = \Slim\Slim::getInstance();
            $app->flash('error', 'Login required');
            $app->redirect('/login');
        }
    };
};
/*
function functionName(){
    session_start();
    if(isset($_SESSION['admin'])){
        $app = \Slim\Slim::getInstance();
        
        //$app->pass();
        return true;
    }else{
            $app = \Slim\Slim::getInstance();
            $app->flash('error', 'Login required');
            $app->redirect('/login');
    }
}

$app->get('/testeauth', functionName, function () {
    
    echo " Olá ".$_SESSION['admin'].". Seu perfil de acesso é ".$_SESSION['perfil'];

     
    
});
*/

$app->post('/testerecebejson', function () use ($app) {

    //$json = json_decode(file_get_contents("php://input"));
	$json = $_POST['json'];
        
        //echo var_dump($_POST);
//   echo json_encode($json);

//
//        shell_exec('rm escrevendo.json');
//        
//        $fp = fopen("escrevendo.json", "w+");
//
//
//        // Escreve o conteúdo JSON no arquivo
//        $escreve = fwrite($fp, "teste".var_dump($_POST));
//
//        // Fecha o arquivo
//        fclose($fp);

      //  $app->response->headers->set('Content-Type', 'aplication/json');
        // $app->response->setBody($json);
        echo json_encode($json);
});


//$data = json_decode($app->request->getBody());
$app->run();
?>
