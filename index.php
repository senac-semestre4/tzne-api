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
require_once ROOT_DIR . '/Dao/MysqlConn.php';

//instancie o objeto

$settings = [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
    ],
];
$app = new \Slim\Slim($settings);
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

        $app->post('/inserevenda', 'clienteLogado', function () use ($app) {
            //session_destroy();
            
            
            $objson = $_POST['json'];
            $b = json_decode($objson);
            
            
            session_id($b->{'PHPSESSID'});
                
                if (!isset($_SESSION)) {
                session_start();
                } else {
                    //echo"ja tem sessao";
                }
            
            
                $clienteId = intval($_SESSION['cliente_id']);
                
                
                
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
            

            //Objeto venda com dois produtos
//            $objson ='{"client_client_id":1,"total_partial":230,"amount":115,"discount":0,"type_freight":"correios","value_freight":16,"number_plots":2, "itens":
//                      [{"product_product_has_id":153,"product_name": "Camiseta Homem Aranha","unit_price":57.50,"quantity":6,"subtotal":115},{"product_product_has_id":178,"product_name": "Camiseta Homem Aranha","unit_price":57.50,"quantity":2,"subtotal":115}]}';
            // $a= json_encode(json_decode($objson, JSON_PRETTY_PRINT));
            //Decodifica string json para objeto php
            
            

            //$b= $objson;
            //Seta os valores da venda recebidos pelo objeto JSON
            $sale->setAmount($b->{'amount'});
            $sale->setClientClientId($clienteId);
            $sale->setDiscount($b->{'discount'});
            $sale->setNumberPlots($b->{'number_plots'});
            $sale->setTotalPartial($b->{'total_partial'});
            $sale->setTypeFreight($b->{'type_freight'});
            $sale->setValueFreight($b->{'value_freight'});


            $dao = new DaoProducts();
            //Laço de repetição que irá popular os itens de venda, na venda
            for ($i = 0; $i < sizeof($b->itens); $i++) {
                $p = new Product();
                $dao = new DaoProducts();
                $p = $dao->listByasId($b->{'itens'}[$i]->product_product_has_id);
                $p->setOptions($p->serializeOptions());

                if ($p->getProductQuantity() < $b->{'itens'}[$i]->quantity) {
                    $app->response->headers->set('Content-Type', 'application/json');
                    $erro = substr_replace(json_encode($b), '"quantidadeAlterada":true,', 1, 0);
                    $str = preg_replace("/\"quantity\":" . $b->{'itens'}[$i]->quantity . "/", "\"quantity\":" . $p->getProductQuantity(), $erro);
                    //echo json_encode($objson, JSON_PRETTY_PRINT);
                    $app->response->headers('Access-Control-Allow-Origin', 'http://localhost:8000');
                    $app->response->headers('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
                    $app->response->headers('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');


                    $app->response->setBody($str);
                    //echo $erro;
                    break;
                } else {
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


 $app->get('/listarpedidos', function () {
            $dao = new DaoSale();

            $json = $dao->listSalesStatus();

            $obj = json_decode($json);

            echo $json;


/*

        //lista todos os pedidos
        $app->get('/listarpedidos', function () {
            $dao = new DaoSale();

            $json = $dao->listSalesStatus();

            $obj = json_decode($json);

            echo $json;
/*
            for ($i = 0; $i < sizeof($obj); $i++) {

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
            }*/
            //echo "</table>";
            // echo "</tr>";
            //echo $json;
        })->setName('listarpedidos');

        $app->post('/atualizastatuspedido', function () {
            $dao = new DaoSale();
            $dao->updateStatusSale(intval($_POST['saleid']), intval($_POST['status']));
        })->setName('atualizastatuspedido');


        $app->get('/listavendas', function () {
            $conn = new MysqlConn();
            $conn->Conecta();
            $query = "SELECT sale_id,client_client_id,order_status_order_status_id,
                date,  amount, discount,
                total_partial, number_plots, subtotal FROM `sales`
                    INNER JOIN sale_has_order_status
                    ON sale_has_order_status.sales_sale_id =sales.sale_id
                    INNER JOIN item_for_sale
                    ON item_for_sale.sale_id_sale = sales.sale_id
                    GROUP by sales.sale_id";

            if ($result = mysqli_query($conn->getLink(), $query)) {


                if (!mysqli_num_rows($result)) {
                    echo "Sem resultado";
                } else {
                    $p = new Product();
                    while ($row = mysqli_fetch_assoc($result)) {

                        //armazena linha em cada posição do array json

                        $json[] = $row;
                    }
                }
            }




            echo json_encode($json);
        })->setName('listavendas');
        $app->get('/listavendas/:id', function ($id) {
            $conn = new MysqlConn();
            $conn->Conecta();
            $query = "SELECT sale_id,client_client_id,order_status_order_status_id,
                date, amount, discount,
                total_partial, number_plots, subtotal FROM `sales`
                    INNER JOIN sale_has_order_status
                    ON sale_has_order_status.sales_sale_id =sales.sale_id
                    INNER JOIN item_for_sale
                    ON item_for_sale.sale_id_sale = sales.sale_id WHERE sale_id = {$id} GROUP BY sales.sale_id";

            if ($result = mysqli_query($conn->getLink(), $query)) {


                if (!mysqli_num_rows($result)) {
                    echo "Sem resultado";
                } else {
                    $p = new Product();
                    while ($row = mysqli_fetch_assoc($result)) {

                        //armazena linha em cada posição do array json

                        $json[] = $row;
                    }
                }
            }

            echo json_encode($json);
        })->setName('listavendasid');


        $app->get('/listaitensvendas/:id', function ($id) {
            $conn = new MysqlConn();
            $conn->Conecta();
            $query = "SELECT * FROM `item_for_sale` WHERE sale_id_sale = " . $id;

            if ($result = mysqli_query($conn->getLink(), $query)) {


                if (!mysqli_num_rows($result)) {
                    echo "Sem resultado";
                } else {
                    $p = new Product();
                    while ($row = mysqli_fetch_assoc($result)) {

                        //armazena linha em cada posição do array json

                        $json[] = $row;
                    }
                }
            }

            echo json_encode($json);
        })->setName('listaitensvendasid');

        $app->get('/listavendacliente/:id', function ($id) {
            $conn = new MysqlConn();
            $conn->Conecta();
            $query = "SELECT * FROM `sales` WHERE client_client_id = " . intval($id);

            if ($result = mysqli_query($conn->getLink(), $query)) {


                if (!mysqli_num_rows($result)) {
                    echo "Sem resultado";
                } else {
                    $p = new Product();
                    while ($row = mysqli_fetch_assoc($result)) {

                        //armazena linha em cada posição do array json

                        $json[] = $row;
                    }
                }
            }
            // echo var_dump(mysqli_error($conn->getLink()));
            echo json_encode($json);
        })->setName('listavendacliente');


        //Atualiza o status do pedido
        $app->get('/atualizastatuspedido/:orderstatusid/:salessaleid', function ($orderstatusid, $salessaleid) {
            $dao = new DaoSale();

            if ($dao->updateStatusSale($orderstatusid, $salessaleid)) {
                $json = "{'atualizado':'true'}";
                // echo json_encode($json);
            } else {
                $json = "{'atauluzado':'false'}";
                //echo json_encode($json);
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
        $app->get('/listarprodutoshasid/:hasid', function ($hasid) {
            $p = new Product();
            $dao = new DaoProducts();
            $p = $dao->listByasId($hasid);
            $p->setOptions($p->serializeOptions());
            echo json_encode($p->serializeProduct());
        })->setName('listarprodutoshasid/:hasid');

        //Listar produtos com limit e offset
        $app->get('/listarprodutos/:limit/:offset', function ($limit, $offset) {
            $dao = new DaoProducts();
            $dao->listAlLProducts($limit, $offset);
        })->setName('listarprodutos/:limit/:offset');
        //Inserir produto redireciona para a controller que insere



        $app->post('/inserirproduto', function () use($app) {
            //$app->redirect('/Controller/InsereProduto.php', 307);
            $json = $_POST['json'];
//                        echo json_encode($json);

            $objson = $_POST['json'];

            $b = json_decode($objson);

            //  $sale->setAmount($b->{'amount'});
            // ini_set('display_errors', 1);
            /*
             * Este arquivo juntei o php e html para facilitar a motagem do teste. 
             * Esse poderá ser usado como interface para cadastro de produtos
             */

            //Verifica se o post vindo do name "code", no html, está vazio, 
            //se não recebe os parâmetros e tenta inserir no banco
            //$url = "http://tzne.com.br/View/TestesViews/ViewsProdutos/insereproduto.php";
            //$url = "http://tzne.kwcraft.com.br/View/TestesViews/ViewsProdutos/insereproduto.php";
//                        $p = new Product();
//                        $p->setId(null);
//                        $p->setName($b->{'name'}); 
//                        $p->setModel($b->{'model'}); 
//                        $p->setDescription($b->{'description'}); 
//                        $p->setCode($b->{'code'}); 
//                        $p->setSpecification($b->{'specification'}); 
//                        $p->setPurchase_price($b->{'purchase_price'}); 
//                        $p->setSalePrice($b->{'sale_price'}); 
//                        $p->setProfit_margin($b->{'profit_margin'}); 
//                        $p->setPromotional_price($b->{'promotional_price'}); 
//                        $p->setLength($b->{'length'}); 
//                        $p->setWidth($b->{'width'}); 
//                        $p->setHeigth($b->{'heigth'}); 
//                        $p->setImg_relative_url($b->{'img_relative_url'}); 
//                        $p->setStatus($b->{'status'}); 
//                        $p->setBrands_brand_id($b->{'brands_brand_id'});
//                        $p->setDepartaments_departament_id($b->{'departaments_departament_id'});
//
//                        $arrayOptions =  array();
//
//                        $options = new ProductOpitons();
//                        $options->setProductQuantity($_POST['product_stock_quantity']);
//                        $options->setSize($_POST['idsize']);
//                        $options->setColor($_POST['idcolor']);
////
//
//                        $arrayOptions[] = $options->serializeOptions();
//                        $p->setOptions($arrayOptions);
////                        
//                        
//                        
//                        $dao = new DaoProducts;
//
//                        $dao->insertProduct($p, $arrayOptions);
            //header("Location: ".$url);
            // echo "Inserido";
            // Caso contrário mostra o  formulário para inserir o produto    
            // $json = '{"Everton manja de angular?": false}';            
            // echo json_encode($json);
            //echo $json;


            $p = new Product();
            $p->setId(null);
            $p->setName($_POST['name']);
            $p->setModel($_POST['model']);
            $p->setDescription($_POST['description']);
            $p->setCode($_POST['code']);
            $p->setSpecification($_POST['specification']);
            $p->setPurchase_price($_POST['purchase_price']);
            $p->setSalePrice($_POST['sale_price']);
            $p->setProfit_margin($_POST['profit_margin']);
            $p->setPromotional_price($_POST['promotional_price']);
            $p->setLength($_POST['length']);
            $p->setWidth($_POST['width']);
            $p->setHeigth($_POST['heigth']);
            $p->setImg_relative_url($_POST['img_relative_url']);
            $p->setStatus($_POST['status']);
            $p->setBrands_brand_id($_POST['brands_brand_id']);
            $p->setDepartaments_departament_id($_POST['departaments_departament_id']);
            $arrayOptions = array();
            $options = new ProductOpitons();
            $options->setProductQuantity($_POST['product_stock_quantity']);
            $options->setSize($_POST['idsize']);
            $options->setColor($_POST['idcolor']);
            $arrayOptions[] = $options;
            $dao = new DaoProducts;
            $dao->insertProduct($p, $arrayOptions);
//header("Location: ".$url);
            //echo "Inserido";



           // echo json_encode($p->serializeProduct());
            //echo $b->{'name'};
        })->setName('insereproduto');




        $app->get('/listarprodutoscaracteristica/:id/:cor/:tam', function ($id, $cor, $tam) {
            $p = new Product();
            $dao = new DaoProducts();
            $p = $dao->listProductByCaracteristics($id, $cor, $tam);
            echo json_encode($p->serializeProduct());
        })->setName('/listarprodutoscaracteristica');
    });

    $app->get('/listadecores', function () {
        $conn = new MysqlConn();
        $conn->Conecta();

        $query = "SELECT * FROM `products_color`";

        if ($result = mysqli_query($conn->getLink(), $query)) {


            if (!mysqli_num_rows($result)) {
                echo "Sem resultado";
            } else {
                $p = new Product();
                while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json

                    $json[] = $row;
                }
            }
        }

        echo json_encode($json);
    })->setName('/listadecores');


    $app->get('/listadetamanhos', function () {
        $conn = new MysqlConn();
        $conn->Conecta();

        $query = "SELECT * FROM `products_size`";

        if ($result = mysqli_query($conn->getLink(), $query)) {


            if (!mysqli_num_rows($result)) {
                echo "Sem resultado";
            } else {
                $p = new Product();
                while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json

                    $json[] = $row;
                }
            }
        }

        echo json_encode($json);
    })->setName('/listadetamanhos');

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

            $peso = $_POST['quantidade'] * 0.200;
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
            $parametros['nVlAltura'] = '10';
            $parametros['nVlLargura'] = '16';
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


$app->post('/contato', function () use ($app) {
//Verifico se há sessão aberta, se não abre uma nova


    if (!isset($_SESSION)) {
        session_start();
    } else {
        //echo"ja tem sessao";
    }

//Verifico se o número gerado é o mesmo que está na sessão
//if (  $_POST['seed'] == $_SESSION['seed'] ){
    if (true) {

        /* se removo ele da sesssão para não permitir um novo uso do mesmo, assim evitando a duplicidade de registros nobanco,
          por cliques duplicados.
         */
        unset($_SESSION['seed']);



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
            $assunto = $_POST['txtassunto'];



            $mensagem = "DE: " . $contato . "\nTel: " . $tel . "\nMensagem:\n\n" . $_POST['txtmsg'];

            $h = new HelpDesk();
            $h->setClientName($nome);
            $h->setEmail($contato);
            $h->setTel($tel);
            $h->setShortDescription($assunto);
            $h->setProbReported($_POST['txtmsg']);



            $dao = new DaoHelpdesk();
            $json;
            if ($dao->createProtocol($h)) {
                $json = "{'protocoloinserido':'true'}";
                echo json_encode($json);
            } else {
                $json = "{'protocoloinserido':'false'}";
                echo json_encode($json);
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

            //$app->redirect('/resutadoprotocolo');
            //echo json_encode($json);
        } else {
            error_reporting(1);
        }
    } else {
        echo 'Este comando ja foi processado ou nao foi enviado por um
formulario valido';
    }
});


$app->get('/resutadoprotocolo', function () {

    echo "Protocolo enviado<br>";
    echo ' <a href="http://tzne.kwcraft.com.br/View/formulario-contato.html">Abrir novo chamado ?</a> ';
});


//************************************************************
/*
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
 */


$app->get('/listarprotocolos/', 'usuarioLogado', function () {
//         ini_set('display_errors', 1);       
    if (!isset($_SESSION)) {
        session_start();
    } else {
        //echo"ja tem sessao";
    }
    echo "Bem vindo " . $_SESSION["admin"] . "<br>";
    $conn = new MysqlConn();
    $conn->Conecta();

    $busca = ""
            . "SELECT * FROM `helpdesk_protocols` "
            . "INNER JOIN helpdesk_status "
            . "ON helpdesk_protocols.protocol_status = helpdesk_status.id_status order by helpdesk_protocols.id_protocol";
//O vetor a baixo exemplifica as informações contidas no banco de dados.
    $dao = new DaoHelpdesk();

    $obj = json_decode($dao->listProcotols());


//echo var_dump($obj);
    $json = array();

    $result = mysqli_query($conn->getLink(), $busca);
    /* While
     * Enquanto haver linhas da tabela para ser
     * lida, essas serão armazenadas na row
     */
    while ($row = mysqli_fetch_assoc($result)) {

        //armazena linha em cada posição do array json
        $json[] = $row;
    }


    $vetProdutos = $json;
    $totalPagina = 5; //Variável que armazena a quantidade de produtos por página.
//Verifica se exite alguma query string com o valor da página, se não houver, define o valor 1.
    $pagina = (filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) : 1);

    /*
      ceil() - Arredonda um valor para cima, por exemplo, 5.5 arredonda para 6, pois assim vai exibir cinco na primeira página e um na próxima.$_COOKIE
      count() - Conta a quantidade de valores do vetor
      15 / 5 = 3 Paginas
      16 / 5 = 3,2 | arredondamos para cima e temos 4 páginas.
     */
    $quantidadePaginas = ceil(count($vetProdutos) / $totalPagina);

    $fim = ($pagina * $totalPagina); //Multiplicamos a página atual pela quantidade de itens por página: P=4 I= 5 | 4 * 5 = 20;
    $inicio = ($fim - $totalPagina); //Subtraimos o total de páginas pela quantidade final a ser exibido: FIM = 20 Tot. Pag. = 5 | 20 - 5 = 15
    ?>

    <?php
    echo "<!DOCTYPE html>
<html>
    <head>
        <title>Listar Protocolos</title>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
<style>

 td {
   text-align: center;   
}

 th {
   text-align: center;   
}

</style>
</head>
    <body>
                        <div class=\"container\">
  <table class=\"table\">

   <thead>
    <tr>
      <th>Id</th>
      <th>Cliente</th>
      <th>Status</th>
      <th>Abertura</th>
      <th></th>
    </tr>
  </thead>";
    ?>   
    <div id="dvConteudo">
        <br>
        <?php
        for ($j = $inicio; $inicio < $fim; $inicio++) {
            if (!empty($vetProdutos[$inicio])) {//Verificamos se as demais posições possuem algum valor
                //echo "<span style='color: red;'-->- {$vetProdutos[$inicio]['client_name']}<br>";
                echo "<form action=\"/listarprotocoloid\" method =\"POST\">
            <input type=\"hidden\" name=\"id_protocol\" value=\"{$obj[$inicio]->id_protocol}\">
  <tbody>
    <tr>
      <td>
        {$obj[$inicio]->id_protocol}
      </td>
      <td>
        {$obj[$inicio]->client_name}
      </td>
      <td>
        {$obj[$inicio]->name_status}
      </td>
      <td>
        {$obj[$inicio]->creation_date}
      </td>
      <td>
        <button class=\"btn btn-dark\" type=\"submit\">Ver chamado</button>
      </td>
    </tr>
                        </form>";
            }
        }
        ?>
        <br>
        <?php
        echo"
  </tbody>
</table>
</body>
</html>
<ul class=\"pagination\">
";
        //Montamos a quantidade de botões

        for ($i = 0; $i < $quantidadePaginas; $i++) {
            ?>
            <li> <a href="?pagina=<?= ($i + 1); ?>" style="color: #111; text-decoration: none; background-color: #CCC; padding: 5px; border:1px solid #eee; font-weight: bold;"><?= ($i + 1); ?></a></li>
            <?php
        }
        ?>

    </div>
    <?php
})->setName('listaprotocolos');


$app->post('/listarprotocoloid', 'usuarioLogado', function () {

    $dao = new DaoHelpdesk();
    /* echo var_dump(intval($_POST['id_protocol']));
      echo var_dump(intval($_POST['protocol_status']));
      echo var_dump($_POST['resolved_by']);
      echo var_dump($_POST['solotion']); */

    $result = $dao->listProcotolsId(intval($_POST['id_protocol']));
    $result = json_decode($result);

    echo "
	<!DOCTYPE html>
<html>
    <head>
        <title>Listar Protocolos</title>
    		  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>

<style>

.table td {
   text-align: center;   
}
</style>

			
	</head>
    <body>
	
	     <div class=\"container\">
             
<form id ='{$result[0]->id_protocol}' action = \"/atualizaprotocolos\" method =\"POST\">

		<table class=\"table table-bordered table-responsive\">
                    <thead>


             <tr>
                         <th>Protocolo</th>
                         <th>Cliente</th>
                         <th>Email</th>
                         <th>Telefone</th>
                         <th>Assunto</th>
                         <th>Problema</th>
             </tr>
                    </thead>       

			<tbody>

                     <tr>
                             <input type = \"hidden\" name=\"id_protocol\" value =\"{$result[0]->id_protocol}\">
                             <td>{$result[0]->id_protocol}</td>
                             <td>{$result[0]->client_name}</td>
                             <td>{$result[0]->email}</td>
                             <td>{$result[0]->tel}</td>
                             <td>{$result[0]->short_description}</td>
                             <td><textarea disabled class=\"form-control\" rows=\"5\" name=\"prob_reported\" value=\"\">{$result[0]->prob_reported}</textarea></td>
                        </tr>
              <tr>
                         <th>Solução</th>
                         <th>Status</th>
                         <th>Status atual</th>
                         <th>Criado em</th>
                         <th>Resolvido por</th>
             </tr>
                        <tr>
                           <td><textarea class=\"form-control\" rows=\"5\"  name=\"solotion\"  value=\"\">{$result[0]->solotion}</textarea></td>
                             <td>  
                                        <select id=\"protocol_status\" name=\"protocol_status\">
                                           <option value=\"{$result[0]->protocol_status} selected\"> {$result[0]->name_status}</option>
					   <option value=\"1\">Aberto</option>
                                           <option value=\"2\">Em andamento</option>
                                           <option value=\"3\">Resolvido</option>
                                        </select></td>
                             <td>{$result[0]->name_status}</td>
                             <td>{$result[0]->creation_date}</td>
                             <td><input class=\"form-control\" type=\"text\" name=\"resolved_by\" value=\"{$result[0]->resolved_by}\"></td>                                                                                   
                     </tr>
                     </tr>
			</tbody>
                     <br>
		<tbody>        
		</table>
           <div>
          <input type=\"submit\" name=\"atualizar\" value=\"Atualizar\" class=\"btn btn-dark\">
          <div>
	      </form>

	<a href=\"http://tzne.kwcraft.com.br/listarprotocolos\" class=\"btn btn-dark\">Voltar a lista de chamados</a>
    
	</div>

";
    ?>
    <section id="contact">
        <div class="section-content">
            <h1 class="section-header"><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s"> Cadastro de Produto</span></h1>
            <h3></h3>
        </div>
        <!--            <div class="contact-section">-->
        <div class="container">
            <form id="form" name="form" method="POST" action="/api/produtos/inserirproduto">
                <div class="col-md-6 form-line">
                    <div class="form-group">
                        <label for="name">Nome do produto</label>
                        <input type="text" class="form-control" id="txtnome" name="name" placeholder=" Nome do produto">
                    </div>
                    <div class="form-group">
                        <label for="model">Modelo</label>
                        <input type="text" class="form-control" id="txtnome" name="model" placeholder=" Modelo">
                    </div>

                    <div class="form-group">
                        <label for="description"> Descrição</label>
                        <textarea class="form-control" rows="3" id="txtmsg" name="description" placeholder=" Descrição"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="specification">Especificação</label>
                        <textarea class="form-control" rows="3" id="txtmsg" name="specification" placeholder=" Especificação"></textarea>

                    </div>

                    <div class="form-group">
                        <label for="code">Código</label>
                        <input type="text" class="form-control" id="txtnome" name="code" placeholder=" Código">
                    </div>

                    <div class="form-group">
                        <label for="sale_price">Preço de venda</label>
                        <input type="text" class="form-control" id="txtnome" name="sale_price" placeholder=" Preço de venda">
                    </div>
                    <div class="form-group">
                        <label for="profit_margin">Margem de lucro</label>
                        <input type="text" class="form-control" id="txtnome" name="profit_margin" placeholder=" Margem de lucro">
                    </div>


                    <div class="form-group">
                        <label for="promotional_price">Preço promocional</label>
                        <input type="text" class="form-control" id="txtemail" name="promotional_price" placeholder=" Preço promocional">
                    </div>	
                    <div class="form-group">
                        <label for="length">Comprimento</label>
                        <input type="text" class="form-control" id="txttel" name="length" placeholder=" Comprimento">
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="width">Largura</label>
                        <input type="text" class="form-control" id="chamado" name="width" placeholder=" Largura">
                    </div>

                    <div class="form-group">
                        <label for="heigth">Altura</label>
                        <input type="text" class="form-control" id="chamado" name="heigth" placeholder=" Altura">
                    </div>


                    <div class="form-group">
                        <label for="width">Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Ativo</option>
                            <option value="0">Desativado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_stock_quantity">Quantidade em estoque </label>
                        <input type="text" class="form-control" id="chamado" name="product_stock_quantity" placeholder=" Quantidade em estoque ">
                    </div>
                    <div class="form-group">
                        <label for="brands_brand_id">Marca</label>
                        <input type="text" class="form-control" id="chamado" name="brands_brand_id" placeholder=" Marca">
                    </div>
                    <div class="form-group">
                        <label for="departaments_departament_id">Departamento</label>
                        <input type="text" class="form-control" id="chamado" name="departaments_departament_id" placeholder=" Departamento">
                    </div>

                    <div class="form-group">
                        <label for="idcolor">Cor</label>
                        <input type="text" class="form-control" id="chamado" name="idcolor" placeholder=" Largura">
                    </div>



                    <div class="form-group">
                        <label for="idsize">Tamanho</label>
                        <input type="text" class="form-control" id="chamado" name="idsize" placeholder=" Largura">
                    </div>

                    <div class="form-group">
                        <label for="img_relative_url">URL da imagem</label>
                        <input type="text" class="form-control" id="chamado" name="img_relative_url" placeholder=" Largura">
                    </div>





                    <div>

                        <button type="button" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Enviar</button>
                    </div>

                </div>
            </form>
        </div>
        <!--</div>-->
    </section>
    <script type="text/javascript">

    </script>



    <?php
})->setName('listarprotocoloid');



$app->post('/atualizaprotocolos', function () {
    $dao = new DaoHelpdesk();
    /* echo var_dump(intval($_POST['id_protocol']));
      echo var_dump(intval($_POST['protocol_status']));
      echo var_dump($_POST['resolved_by']);
      echo var_dump($_POST['solotion']); */

    $dao->updateProtocol(
            intval($_POST['id_protocol']), intval($_POST['protocol_status']), $_POST['resolved_by'], $_POST['solotion']);
    
    	require_once ROOT_DIR . '/View/Mailer/class.phpmailer.php';



            $mailer = new PHPMailer();
            $nome = $_POST['cliente'];
            $contato = $_POST['email'];
            $assunto = $_POST['assunto'];



            $mensagem = "DE: TZNE  "   . $_POST['solotion'];
   
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


    
    
    
    
    ?>


    <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="robots" content="noindex, nofollow">

            <title>Contact Form - One page  - Bootsnipp.com</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css">


                a{
                    color:#63b7ff;
                }
                td {
                    text-align: center;   
                    color: #eeeeee;

                }

                th {
                    text-align: center;   
                    color: #eeeeee;

                }


                select {
                    color: #999999;
                }
                /*Contact sectiom*/
                .content-header{
                    font-family: 'Oleo Script', cursive;
                    color:#fcc500;
                    font-size: 45px;
                }

                .section-content{
                    text-align: center; 

                }
                #contact{

                    font-family: 'Teko', sans-serif;
                    padding-top: 60px;
                    width: 100%;
                    width: 100vw;
                    height: 100%;
                    /*                background: #3a6186;  fallback for old browsers 
                                    background: -webkit-linear-gradient(to left, #3a6186 , #89253e);  Chrome 10-25, Safari 5.1-6 
                                    background: linear-gradient(to left, #3a6186 , #89253e);  W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ 
                    */ color : #fff;    
                }
                .contact-section{
                    padding-top: 40px;
                }
                .contact-section .col-md-6{
                    width: 50%;
                }

                .form-line{
                    /*                border-right: 1px solid #B29999;*/
                }

                .form-group{
                    margin-top: 10px;
                }
                label{
                    font-size: 1.3em;
                    line-height: 1em;
                    font-weight: normal;
                }
                .form-control{
                    font-size: 1.3em;
                    color: #080808;
                }
                textarea.form-control {
                    height: 108px;
                    /* margin-top: px;*/
                }

                .submit{
                    font-size: 1.1em;
                    float: right;
                    width: 150px;
                    background-color: transparent;
                    color: #fff;

                }

                body{
                    background: #3a6186; /* fallback for old browsers */
                    background: -webkit-linear-gradient(to left, #3a6186 , #89253e); /* Chrome 10-25, Safari 5.1-6 */
                    background: linear-gradient(to left, #3a6186 , #89253e); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

                }

            </style>
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript">
        window.alert = function () {
        };
        var defaultCSS = document.getElementById('bootstrap-css');
        function changeCSS(css) {
            if (css)
                $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="' + css + '" type="text/css" />');
            else
                $('head > link').filter(':first').replaceWith(defaultCSS);
        }
        $(document).ready(function () {
            var iframe_height = parseInt($('html').height());
            window.parent.postMessage(iframe_height, 'https://bootsnipp.com');
        });
            </script>
        </head>
        <body style="">
            <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Teko:400,700" rel="stylesheet">
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

            <?php
            include './admin/templates/menu.php';
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-success col-xs-6 col-md-offset-3" role="alert">Chamado atualizado com sucesso!</div>

                        <div class="col-xs-12">
                            <a  class="btn btn-info" href="http://tzne.kwcraft.com.br/admin/listarprotocolos">Voltar a lista de chamados</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
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

//******************************
//*****************************

        /*
          $authenticateForRole = function ( $role = 'member' ) {
          return function () use ( $role ) {
          $user = User::fetchFromDatabaseSomehow();
          if ( $user->belongsToRole($role) === false ) {
          $app = \Slim\Slim::getInstance();
          $app->flash('error', 'Login required');
          $app->redirect('/login');
          }
          };
          }; */





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


        /*
          Função que valida se o usuário está logado antes de exibir a página
         */

        
//              
//        $clienteLogado = function ($post) {
//    
//            $app = \Slim\Slim::getInstance();
//            
//            echo var_dump($post);
////$app->flash('error', 'Login required');
//            
//            $app->stop();
//        
//};
        
        
        function usuarioLogado() {

            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }
            if (!isset($_SESSION["admin"])) {
                //Resgato uma instância existente de Slim
                $app = \Slim\Slim::getInstance();
                $app->flash('error', 'Login required');
//        $app->response->headers->set('Content-Type', 'aplication/json');
                $json = array('logado' => false);
                echo json_encode($json);
//     $app->redirect('/View/TestesViews/ViewLogin/telalogincliente.php');  
                $app->stop();
            }
        }
        
        
            function clienteLogado() {
                 $app = \Slim\Slim::getInstance();
                
                $objson = $app->request()->post('json');
                
                
           // $objson = $_POST['json'];
            $b = json_decode($objson);
            
            
            session_id($b->{'PHPSESSID'});
                
                if (!isset($_SESSION)) {
                session_start();
                } else {
                    //echo"ja tem sessao";
                }
            
            
                $clienteId = intval($_SESSION['cliente_id']);
                
                
                    if (!isset($_SESSION["cliente_id"])) {
                        //Resgato uma instância existente de Slim
                        $app = \Slim\Slim::getInstance();
                        $app->flash('error', 'Login required');
                //        $app->response->headers->set('Content-Type', 'aplication/json');
                        $json = array('autenticado' => false);
                        echo json_encode($json);
                        //$app->redirect('/admin');
                        $app->stop();
                    }
            }

/*
          Antes de permitir o acesso a paginaqualquer, verifico se o usuário está
          previamente logado com a função usuarioLogado();
         */
        $app->get('/paginaqualquer/', 'usuarioLogado', function () {
//         ini_set('display_errors', 1);       
            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }
            echo "vc está logado " . $_SESSION["cliente"] . "<br>";
            $conn = new MysqlConn();
            $conn->Conecta();

            $busca = ""
                    . "SELECT * FROM `helpdesk_protocols` "
                    . "INNER JOIN helpdesk_status "
                    . "ON helpdesk_protocols.protocol_status = helpdesk_status.id_status order by helpdesk_protocols.id_protocol";
//O vetor a baixo exemplifica as informações contidas no banco de dados.
            $dao = new DaoHelpdesk();

            $obj = json_decode($dao->listProcotols());


//echo var_dump($obj);
            $json = array();

            $result = mysqli_query($conn->getLink(), $busca);
            /* While
             * Enquanto haver linhas da tabela para ser
             * lida, essas serão armazenadas na row
             */
            while ($row = mysqli_fetch_assoc($result)) {

                //armazena linha em cada posição do array json
                $json[] = $row;
            }


            $vetProdutos = $json;
            $totalPagina = 5; //Variável que armazena a quantidade de produtos por página.
//Verifica se exite alguma query string com o valor da página, se não houver, define o valor 1.
            $pagina = (filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) : 1);

            /*
              ceil() - Arredonda um valor para cima, por exemplo, 5.5 arredonda para 6, pois assim vai exibir cinco na primeira página e um na próxima.$_COOKIE
              count() - Conta a quantidade de valores do vetor
              15 / 5 = 3 Paginas
              16 / 5 = 3,2 | arredondamos para cima e temos 4 páginas.
             */
            $quantidadePaginas = ceil(count($vetProdutos) / $totalPagina);

            $fim = ($pagina * $totalPagina); //Multiplicamos a página atual pela quantidade de itens por página: P=4 I= 5 | 4 * 5 = 20;
            $inicio = ($fim - $totalPagina); //Subtraimos o total de páginas pela quantidade final a ser exibido: FIM = 20 Tot. Pag. = 5 | 20 - 5 = 15
            ?>

            <?php
            echo "<!DOCTYPE html>
<html>
    <head>
        <title>Listar Protocolos</title>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
<style>

 td {
   text-align: center;   
}

 th {
   text-align: center;   
}

</style>
</head>
    <body>
                        <div class=\"container\">
  <table class=\"table\">

   <thead>
    <tr>
      <th>Id</th>
      <th>Cliente</th>
      <th>Status</th>
      <th>Abertura</th>
      <th></th>
    </tr>
  </thead>";
            ?>   
            <div id="dvConteudo">
                <br>
                <?php
                for ($j = $inicio; $inicio < $fim; $inicio++) {
                    if (!empty($vetProdutos[$inicio])) {//Verificamos se as demais posições possuem algum valor
                        //echo "<span style='color: red;'-->- {$vetProdutos[$inicio]['client_name']}<br>";
                        echo "<form action=\"/listarprotocoloid\" method =\"POST\">
            <input type=\"hidden\" name=\"id_protocol\" value=\"{$obj[$inicio]->id_protocol}\">
  <tbody>
    <tr>
      <td>
        {$obj[$inicio]->id_protocol}
      </td>
      <td>
        {$obj[$inicio]->client_name}
      </td>
      <td>
        {$obj[$inicio]->name_status}
      </td>
      <td>
        {$obj[$inicio]->creation_date}
      </td>
      <td>
        <button type=\"submit\">Ver chamado</button>
      </td>
    </tr>
                        </form>";
                    }
                }
                ?>
                <br>
                <?php
                echo"
  </tbody>
</table>
</body>
</html>";
                //Montamos a quantidade de botões
                for ($i = 0; $i < $quantidadePaginas; $i++) {
                    ?>
                    <a href="?pagina=<?= ($i + 1); ?>" style="color: #111; text-decoration: none; background-color: #CCC; padding: 5px; border:1px solid #eee; font-weight: bold;"><?= ($i + 1); ?></a>
                    <?php
                }
                ?>
            </div>
            <?php
        });
//$data = json_decode($app->request->getBody());
        $app->run();
        ?>
