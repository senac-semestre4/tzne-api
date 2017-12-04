<?php
//header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 
//session_cache_limiter(false);
//
//session_start();
//unset($_SESSION);
//session_destroy();
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';

require ROOT_DIR . '/vendor/autoload.php';
require_once ROOT_DIR . '/Controller/ListarProdutos.php';
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
        //lista todos os pedidos
        $app->get('/listarpedidos', function () {
            $dao = new DaoSale();

            $json = $dao->listSalesStatus();

            $obj = json_decode($json);

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
            }
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

            ini_set( 'display_errors', '1' );
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

            //nome da foto
            $foto = $_FILES["foto"];
            //CAminho salvo no banco
            $caminhoImagemBanco = "http://tzne.kwcraft.com.br/images/produtos/" . $foto["name"];
                        
                      //local onde será salvo  
                      $target_dir = "/var/www/cloud.kwcraft.com.br/public_html/PI4/images/produtos/";
                      //local final a ser gravado no servidor
                      $target_file = $target_dir . basename($_FILES["foto"]["name"]);
                      //Chave que permite realziar o upload, caso passe pelas validações
                      $uploadOk = 1;
                        //Verifica a extensão do arquivo, exemplo .jpg
                      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                   
                    // Verifico se é uma imagem
                     
                        $check = getimagesize($_FILES["foto"]["tmp_name"]);
                        if($check !== false) {
                            //Mostra o tipo do arquivo
                            //echo "Arquivo é uma imagem - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {

                           //echo "Não é imagem";
                            $uploadOk = 0;
                        }
                    
                    // Verifica se o arquivo já existe e para o upload
                    if (file_exists($target_file)) {
                        
                       // echo "Arquivo já existe";
                        $uploadOk = 0;
                    }
                    // Verifico o tamamnho do arquivo se é maior q 50MB
                    if ($_FILES["foto"]["size"] > 500000) {
                        //echo "Arquivo enviado muito grande";
                        $uploadOk = 0;
                    }
                    // Valido os tipos de imagens permitidos
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                        //echo "Somente envie -> JPG, JPEG, PNG & GIF";
                    $uploadOk = 0;
                }
                    // Verifica se a var $uploadOk é zero, se sim, é pq antes não passo em alguma validação
                if ($uploadOk == 0) {
                    //echo "Algo errado ocorreu, upload não realizado";
                    // se estiver tudo certo, o upload é feito
                } else {
                    //move o arquivo temporário para a pasta selecionada
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {

                        //echo "Arquivo". basename( $_FILES["foto"]["name"]). " foi salvo no servidor";
                    } else {
                        //echo "Ocorreu erro ao subir o arquivo";
                    }
                }

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
            $p->setImg_relative_url($caminhoImagemBanco);
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
          //  echo "Inserido";



            //echo json_encode($p->serializeProduct());
            //echo $b->{'name'};

            
            
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
            include './templates/menu.php';
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-success col-xs-6 col-md-offset-3" role="alert">Produdo cadastrado com sucesso!</div>

                        <div class="col-xs-12">
                            <a  class="btn btn-info" href="http://tzne.kwcraft.com.br/admin/insereproduto">Inserir novo produto?</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            
            
            
            
            
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
}); // fim api grupo





$app->get('/listarprotocolos/', 'usuarioLogado', function () {
//         ini_set('display_errors', 1);       
    if (!isset($_SESSION)) {
        session_start();
    } else {
        //echo"ja tem sessao";
    }

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





    <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="robots" content="noindex, nofollow">

            <title>Contact Form - One page  - Bootsnipp.com</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css">

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
            include './templates/menu.php';

            echo "
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
                        echo "<form action=\"/admin/listarprotocoloid\" method =\"POST\">
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
        <button class=\"btn btn-info\" type=\"submit\">Ver chamado</button>
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
<nav aria-label=\"Page\">
<ul class=\"pagination\">
";
                //Montamos a quantidade de botões

                for ($i = 0; $i < $quantidadePaginas; $i++) {
                    ?>
                    <li class="page-item"> <a class="page-link" href="?pagina=<?= ($i + 1); ?>" style="color: #111; text-decoration: none; background-color: #CCC; padding: 5px; border:1px solid #eee; font-weight: bold;"><?= ($i + 1); ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </nav>
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
            include './templates/menu.php';
            ?>

            <section id="contact">
                <div class="section-content">
    <!--                <h1 class="section-header"><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s"> Cadastro de Produto</span></h1>-->
                
                </div>
                <!--            <div class="contact-section">-->
                <div class="container">
                    <form id ="<?php echo $result[0]->id_protocol ?>" action = "/atualizaprotocolos" method ="POST">
                        <div class="col-md-6 col-sm-offset-3 form-line">
                            <input  type = "hidden" name="id_protocol" value ="<?php echo $result[0]->id_protocol ?>">

                            <div class="form-group">
                                <label for="name">Protocolo</label>
                                <input disabled type="text" class="form-control" id="txtnome"  value ="<?php echo $result[0]->id_protocol ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Cliente</label>
                                <input disabled type="text" class="form-control" id="txtnome" name="cliente"  value ="<?php echo $result[0]->client_name ?>">
                            </div>
                            <div class="form-group">
                                <label disabled for="name">Email</label>
                                <input type="text" class="form-control" id="txtnome" name="email" value ="<?php echo $result[0]->email ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Telefone</label>
                                <input disabled type="text" class="form-control" id="txtnome"  value ="<?php echo $result[0]->tel ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Assunto</label>
                                <input disabled type="text" class="form-control" id="txtnome" name="assunto" value ="<?php echo $result[0]->short_description ?>">
                            </div>

                            <div class="form-group">
                                <label  for="description"> Problema</label>
                                <textarea disabled class="form-control" rows="3" id="txtmsg" ><?php echo $result[0]->prob_reported ?></textarea>
                            </div>


                            <div class="form-group">
                                <label for="name">Data de criação</label>
                                <input type="text" class="form-control" id="txtnome"  value ="<?php echo $result[0]->creation_date ?>">
                            </div>

                            <div class="form-group">
                                <label for="protocol_status">Alterar Status</label>
                                <select class="form-control" id="protocol_status" name="protocol_status">
                                    <option value="<?php echo $result[0]->protocol_status ?> selected"> <?php echo $result[0]->name_status ?></option>
                                    <option value="1">Aberto</option>
                                    <option value="2">Em andamento</option>
                                    <option value="3">Resolvido</option>
                                </select></td>
                            </div>
                            <div class="form-group">
                                <label for="name">Resolvido por</label>
                                <input type="text" class="form-control" id="txtnome" name="resolved_by" value ="<?php echo $result[0]->resolved_by ?>">
                            </div>


                            <div class="form-group">
                                <label for="solotion"> Solução</label>
                                <textarea class="form-control" rows="3" id="txtmsg" name="solotion"><?php echo $result[0]->solotion ?></textarea>
                            </div>

                            <div>

                                <button style="margin-bottom: 20px" type="submit" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Enviar</button>
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
            echo ' <a href="http://tzne.kwcraft.com.br/listarprotocolos">Voltar a lista de chamados</a> ';
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
                $app->redirect('/admin');
                //     $app->stop();
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
                        echo "<form action=\"/admin/listarprotocoloid\" method =\"POST\">
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

//Pagina de login
        $app->get('/', function () use ($app) {
//         ini_set('display_errors', 1);       
            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }
            $app->render('/telaloginadmin.php');
        });


        $app->get('/insereproduto', 'usuarioLogado', function () use ($app) {
//         ini_set('display_errors', 1);       
            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }
            $app->render('/insereproduto.php');
        });
//$data = json_decode($app->request->getBody());
        $app->run();
        ?>
