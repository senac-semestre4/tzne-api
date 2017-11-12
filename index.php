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

//instancie o objeto


$app = new \Slim\Slim();
$app->config('debug', true);
//$app->response->headers->set('Content-Type', 'application/json');


//Lista todoas as rotas
$app->get('/listarota/', function() use ($app) {
    $routes = $app->router()->getNamedRoutes();

    foreach ($routes as $route) {
        echo "tzne.kwcraft.com.br{$route->getPattern()}\n";
    }
    exit;
});





//Rota agrupada /API
$group = $app->group('/api', function () use ($app) {

    //*********************GRUPO VENDA***************************************
    $app->group('/venda', function () use ($app) {

        //Insere a venda recebendo parametros do front
        $app->get('/inserevenda', function () {
            //Configurando o horário para a inserção no banco
            date_default_timezone_set("America/Sao_Paulo");

            //Simula venda
            $amount = 55;
            $clientClientId = 1;
            $discount = 0;
            $numberPlots = 2;
            $totalPartial = 55;
            $typeFreight = "correios";
            $valueFreight = 15;


            //Simula item de venda
            $productProductHasId = 178;
            $quantity = 2;
            //$saleIdSale = 10;
            $subtotal = 115;
            $date = date('Y-m-d H:i:s');
            $comment = "Pedido aguardando aprovação.";


            $sale = new Sale();
            $saleItem = new SalesItens();
            $saleItem1 = new SalesItens();

            $sale->setAmount($amount);
            $sale->setClientClientId($clientClientId);
            $sale->setDiscount($discount);
            $sale->setNumberPlots($numberPlots);

            $sale->setTotalPartial($totalPartial);
            $sale->setTypeFreight($typeFreight);
            $sale->setValueFreight($valueFreight);



            $saleItem->setProductProductHasId($productProductHasId);
            $saleItem->setQuantity($quantity);
            $saleItem->setSubtotal($subtotal);
            $saleItem->setDate($date);
            $saleItem->setComment($comment);

            $saleItem1->setProductProductHasId($productProductHasId);
            $saleItem1->setQuantity($quantity);
            $saleItem1->setSubtotal($subtotal);
            $saleItem1->setDate($date);
            $saleItem1->setComment("Pedido aguardando aprovação.");


            $sale->setSalesItens($saleItem);
            $sale->setSalesItens($saleItem1);

            $dao = new DaoSale();
            $dao->insertSale($sale);
        })->setName('inserevenda');
        
        
        //lista todos os pedidos
        $app->get('/listarpedidos', function () {
                $dao = new DaoSale();
                $json = $dao->listSalesStatus();
                echo $json;
        })->setName('listarpedidos');
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
              })->setName('atualizastatuspedido');
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


    If (isset($_POST['txtdest'])) {
        require_once ROOT_DIR . '/View/Mailer/class.phpmailer.php';

        
        
        $mailer = new PHPMailer();
        $destino = $_POST['txtdest'];
        $assunto = $_POST['txtass'];
        $mensagem = "DE: " . $destino . "\nMensagem:\n\n" . $_POST['txtmsg'];
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
        $mailer->Body = $destino;
        $mailer->Body = $mensagem;
        $mailer->Send();


        header('Content-Type: application/json');
        $myObj->status = "enviada";


        $myJSON = json_encode($myObj, JSON_PRETTY_PRINT);

        echo $myJSON;
    } else {
        error_reporting(1);
    }
});


//************************Testes**************************************

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





$app->run();
?>
