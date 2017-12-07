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
        echo "tzne.kwcraft.com.br/admin{$route->getPattern()}\n\n";
    }
    exit;
});





//Rota agrupada /API
$group = $app->group('/api', function () use ($app) {

    //*********************GRUPO VENDA***************************************
    $app->group('/venda', function () use ($app) {
 
        //Insere a venda recebendo parametros do front
        //lista todos os pedidos
        $app->get('/listarpedidos', 'usuarioLogado', function () {
            
           // ini_set( 'display_errors', '1' );   
       /*     $dao = new DaoSale();

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
            
     */       


            
            
            
            
             if (!isset($_SESSION)) {
        session_start();
    } else {
        //echo"ja tem sessao";
    }

    $conn = new MysqlConn();
    $conn->Conecta();

    $busca = ""
            . "SELECT sale_id, client_name, client_client_id,order_status_order_status_id, order_status.name,
                date,  amount, discount,
                total_partial, number_plots, subtotal,date FROM `sales`
                    INNER JOIN sale_has_order_status
                    ON sale_has_order_status.sales_sale_id =sales.sale_id
                    INNER JOIN item_for_sale
                    ON item_for_sale.sale_id_sale = sales.sale_id
                     INNER JOIN client
                    ON sales.client_client_id = client.client_id
                    INNER JOIN  order_status
                    ON order_status.order_status_id = sale_has_order_status.order_status_order_status_id
                    GROUP by sales.sale_id";
//O vetor a baixo exemplifica as informações contidas no banco de dados.
    $dao = new DaoSale();

    $obj = json_decode($dao->listSales());


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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
      <th>Total</th>
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
                        echo "<form id ='{$obj[$i]->saleid}' action = \"/admin/api/venda/atualizastatuspedido\" method =\"POST\">
            <input type=\"hidden\" name=\"saleid\" value=\"{$obj[$inicio]->sale_id}\">

  <tbody>
    <tr>
      <td>
        {$obj[$inicio]->sale_id}
      </td>
      <td>
        {$obj[$inicio]->client_name}
      </td>
      <td>
      <div class=\"form-group\">
         <select class=\"form-control\"  name=\"status\">
           <option value=\"{$obj[$inicio]->order_status_order_status_id} selected\"> {$obj[$inicio]->name}</option>
            <option value=\"1\">Pedido em Aprovação</option>
            <option value=\"2\">Produto a ser enviado</option>
            <option value=\"3\">Pedido entregue</option>
        </select>
        </div>
                           
      </td>
      <td>
        {$obj[$inicio]->date}
      </td>
      <td>
        {$obj[$inicio]->amount}
      </td>

      
      <td>
        <button class=\"btn btn-info\" type=\"submit\">Atualizar Pedido</button>
          <a href=\"http://tzne.kwcraft.com.br/admin/api/venda/listaitensvenda?id_venda={$obj[$inicio]->sale_id}\" class=\"btn btn-info\">Detalhes</a>
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
            
            
            
            
            
            
            
            //echo "</table>";
            // echo "</tr>";
            //echo $json;
        })->setName('listarpedidos');

        
        
         $app->map('/listaitensvenda/', 'usuarioLogado', function () {
            $sale_id;
            if(!isset($_POST['sale_id'])){
                $sale_id = $_GET['id_venda'];
            }else{
                 $sale_id= $_POST['sale_id'];
            }
                        
             if (!isset($_SESSION)) {
        session_start();
    } else {
        //echo"ja tem sessao";
    }

    $conn = new MysqlConn();
    $conn->Conecta();

    $busca = "SELECT * FROM `item_for_sale` WHERE sale_id_sale = " . $sale_id;
//O vetor a baixo exemplifica as informações contidas no banco de dados.
    $dao = new DaoSale();

    $obj = json_decode($dao->listItensSaleById($sale_id));


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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
      <th>Id Venda</th>
      <th>Id produto</th>
      <th>Quantidade</th>
      <th>Subtotal</th>
       <th></th>
    </tr>
  </thead>";
            ?>   
            <div id="dvConteudo">
                <br>
                <?php
                for ($j = $inicio; $inicio < $fim; $inicio++) {
                    if (!empty($vetProdutos[$inicio])) {
                    // //Verificamos se as demais posições possuem algum valor
                        //echo "<span style='color: red;'-->- {$vetProdutos[$inicio]['client_name']}<br>";
                        //$total = $obj[$inicio]->quantity* $obj[$inicio]->subtotal;
                        echo "<form action=\"/admin/api/produtos/listarprodutoshasid\" method =\"GET\">
            <input type=\"hidden\" name=\"hasid\" value=\"{$obj[$inicio]->product_product_has_id}\">
             <input type=\"hidden\" name=\"sale_id\" value=\"{$sale_id}\">
  <tbody>
    <tr>
      <td>
        {$obj[$inicio]->sale_id_sale}
      </td>
      <td> 
        {$obj[$inicio]->product_product_has_id}
      </td>
      <td>
        {$obj[$inicio]->quantity}
      </td>
      <td>
        {$obj[$inicio]->subtotal}
      </td>
      <td>
        <button class=\"btn btn-info\" type=\"submit\">Detalhes</button>
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
   <a href=\"http://tzne.kwcraft.com.br/admin/api/venda/listarpedidos?pagina=1\" class=\"btn btn-info\">Voltar</a>
</body>
</html>
<nav aria-label=\"Page\">
<ul class=\"pagination\">
";
                //Montamos a quantidade de botões

                for ($i = 0; $i < $quantidadePaginas; $i++) {
                    ?>
<!--                     <li class="page-item"> <a class="page-link" href="?pagina=<?= ($i + 1); ?>&sale_id=<?=$_POST['sale_id']?>" style="color: #111; text-decoration: none; background-color: #CCC; padding: 5px; border:1px solid #eee; font-weight: bold;"><?= ($i + 1); ?></a></li> -->
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
    <?php
            
            
            
            
            
        })->via('GET', 'POST')->setName('listaitensvenda');
        
        
        
        
        
        
        
        
        $app->post('/atualizastatuspedido', 'usuarioLogado', function () use ($app) {
            $msgSucesso ="Pedido atualizado";
            $mgsVoltar ="Voltar";
            $href = "http://tzne.kwcraft.com.br/admin/api/venda/listarpedidos";

            $dao = new DaoSale();
            $dao->updateStatusSale(intval($_POST['saleid']), intval($_POST['status']));
             $errorData = array('error' => 'Permission Denied');
            $app->redirect('/admin/templates/sucesso.php?msgSucesso='.$msgSucesso.'&mgsVoltar='.$mgsVoltar
                .'&href='.$href, 301);
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

//           echo json_encode($json);






        })->setName('listavendas');
        
        
       
        
        
        $app->post('/listaitensvendas/:id', 'usuarioLogado', function () {

    $dao = new DaoHelpdesk();
    /* echo var_dump(intval($_POST['id_protocol']));
      echo var_dump(intval($_POST['protocol_status']));
      echo var_dump($_POST['resolved_by']);
      echo var_dump($_POST['solotion']); */

    $result = $dao->listProcotolsId(intval($_POST['sale_id']));
    $result = json_decode($result);
    ?>


    <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="robots" content="noindex, nofollow">

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
                    <form id ="<?php echo $result[0]->id_protocol ?>" action = "/admin/atualizaprotocolos" method ="POST">

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
                                <a href="http://tzne.kwcraft.com.br/admin/listarprotocolos?pagina=1" style="margin-bottom: 20px" class="btn btn-default danger"><i class="fa fa-reply" aria-hidden="true"></i>  Voltar</a>
                            </div>

                        </div>
                    </form>
                </div>

                <!--</div>-->
            </section>
            <script type="text/javascript">

            </script>

            <?php
        })->setName('listaitensvendas/:id');
        
        
        

/*
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

        */
        
        
        
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

        
//########################################
//Listar produtos
        $app->get('/listarprodutos', 'usuarioLogado', function () {
            $dao = new DaoProducts();
            //$dao->listAlLProducts(0, 0);
            
            
                if (!isset($_SESSION)) {
                    session_start();
                } else {
                //echo"ja tem sessao";
                }

          
      
        $p = new Product();
            $dao = new DaoProducts();
            //$p = $dao->listAlLProducts();
            //$p->setOptions($p->serializeOptions());
           //echo json_encode($p->serializeProduct());

           
//echo var_dump($obj);

         //$obj = $p->serializeProduct();
    $json = array();

   $conn = new MysqlConn();
    $conn->Conecta();


   $busca = "SELECT *  FROM products_has_products_size_color_qtd
                INNER JOIN products
                on products_has_products_size_color_qtd.products_product_id = products.product_id";

    $result = mysqli_query($conn->getLink(), $busca);
    
    /* While
     * Enquanto haver linhas da tabela para ser
     * lida, essas serão armazenadas na row
     */
    while ($row = mysqli_fetch_assoc($result)) {

        //armazena linha em cada posição do array json
        $json[] = $row;
    }
    
    $obj = $json;

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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>
            <script type="text/javascript"></script>
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
      <th>Id Produto</th>
      <th>Nome</th>
      <th>Estoque</th>
      <th>Status</th>
      <th>Imagem</th>
      <th>Ação</th>
          </tr>
  </thead>";
            ?>   
            <div id="dvConteudo">
                <br>
                <?php
//                echo "<pre>";
//                echo var_dump($obj);
//                echo "</pre>";
                for ($j = $inicio; $inicio < $fim; $inicio++) {

                    if (!empty($vetProdutos[$inicio])) {
                        
                        $status;
                        if($obj[$inicio]['product_status']==0){
                            $status ="Desativado";
                        }else{
                            $status = "Ativo";
                        }
                        
                        
                    // //Verificamos se as demais posições possuem algum valor
                        //echo "<span style='color: red;'-->- {$vetProdutos[$inicio]['client_name']}<br>";
                        //$total = $obj[$inicio]->quantity* $obj[$inicio]->subtotal;
                        echo "<form action=\"/admin/api/venda/listaitensvenda\" method =\"POST\">
            <input type=\"hidden\" name=\"sale_id\" value=\"{$obj[$inicio]->sale_id}\">
  <tbody>
    <tr>
      <td>
        {$obj[$inicio]['products_product_id']}
      </td>
      <td> 
        {$obj[$inicio]['product_name']}
      </td>
      <td>
        {$obj[$inicio]['product_quantity']}
      </td>
      <td>
        {$status}
      </td>
      <td>
      <a href=\"{$obj[$inicio]['product_img_relative_url']}\" ><img src=\"{$obj[$inicio]['product_img_relative_url']}\"  height=\"42\" width=\"42\"></a>
        
      </td>
      <td>
      <a href=\"http://tzne.kwcraft.com.br/admin/api/produtos/editaproduto?id_produto={$obj[$inicio]['products_product_id']}\" class=\"btn btn-info\">Editar</a>
        
      </td>

    </tr>


</form>
                        ";
                    }
                }

                ?>

                <br>
                <?php
                echo"

  </tbody>

<tr>
     <td>
        <a href=\"http://tzne.kwcraft.com.br/admin/api/venda/listarpedidos?pagina=1\" class=\"btn btn-info\" type=\"submit\">Voltar</button>
      </td>
    </tr>
</table>

</body>
</html>
<nav aria-label=\"Page\">
<ul class=\"pagination\">
";
                //Montamos a quantidade de botões

                for ($i = 0; $i < $quantidadePaginas; $i++) {
                    ?>
                    <li class="page-item"> <a class="page-link" href="?pagina=<?= ($i + 1); ?>&sale_id=<?=$_POST['sale_id']?>" style="color: #111; text-decoration: none; background-color: #CCC; padding: 5px; border:1px solid #eee; font-weight: bold;"><?= ($i + 1); ?></a></li> 
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
    <?php


            
            
            
        })->setName('listarprodutos');
        
        
//###############################################
        //Listar produtos pelo id
        $app->get('/listarprodutos/:id', function ($id) {
            $p = new Product();
            $dao = new DaoProducts();
            $p = $dao->listById($id);
            $p->setOptions($p->serializeOptions());
            echo json_encode($p->serializeProduct());
        })->setName('listarprodutos/:id');

        $app->get('/listarprodutoshasid/', 'usuarioLogado', function ($hasid) {

                 if (!isset($_SESSION)) {
                    session_start();
                } else {
                //echo"ja tem sessao";
                }

            $has_id = $_GET['hasid'];
      
        $p = new Product();
            $dao = new DaoProducts();
            $p = $dao->listByasId($has_id);
            $p->setOptions($p->serializeOptions());
           //echo json_encode($p->serializeProduct());

           
//echo var_dump($obj);

         $obj = $p->serializeProduct();
    $json = array();

   $conn = new MysqlConn();
    $conn->Conecta();


 $busca = "SELECT * FROM "
                      . "`products_has_products_size_color_qtd` "
                      . "INNER JOIN products "
                      . "on products.product_id = products_has_products_size_color_qtd.products_product_id "
                      . "WHERE products_has_products_size_color_qtd.product_has_id = " . $has_id;

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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
      <th>Id Produto</th>
      <th>Nome</th>
      <th>Modelo</th>
      <th>Imagem</th>
       <th></th>
    </tr>
  </thead>";
            ?>   
            <div id="dvConteudo">
                <br>
                <?php
                /*echo "<pre>";
                echo var_dump($obj);
                echo "</pre>";*/
                for ($j = $inicio; $inicio < $fim; $inicio++) {

                    if (!empty($vetProdutos[$inicio])) {
                    // //Verificamos se as demais posições possuem algum valor
                        //echo "<span style='color: red;'-->- {$vetProdutos[$inicio]['client_name']}<br>";
                        //$total = $obj[$inicio]->quantity* $obj[$inicio]->subtotal;
                        echo "<form action=\"/admin/api/venda/listaitensvenda\" method =\"POST\">
            <input type=\"hidden\" name=\"sale_id\" value=\"{$obj[$inicio]->sale_id}\">
  <tbody>
    <tr>
      <td>
        {$obj['id']}
      </td>
      <td> 
        {$obj['name']}
      </td>
      <td>
        {$obj['model']}
      </td>
      <td>
      <a href=\"{$obj['img_relative_url']}\" ><img src=\"{$obj['img_relative_url']}\"  height=\"42\" width=\"42\"></a>
        
      </td>

    </tr>


</form>
                        ";
                    }
                }

                ?>

                <br>
                <?php
                echo"

  </tbody>

<tr>
     <td>
        <a href=\"http://tzne.kwcraft.com.br/admin/api/venda/listaitensvenda?id_venda={$_GET['sale_id']}\" class=\"btn btn-info\" type=\"submit\">Voltar</button>
      </td>
    </tr>
</table>

</body>
</html>
<nav aria-label=\"Page\">
<ul class=\"pagination\">
";
                //Montamos a quantidade de botões

                for ($i = 0; $i < $quantidadePaginas; $i++) {
                    ?>
<!--                     <li class="page-item"> <a class="page-link" href="?pagina=<?= ($i + 1); ?>&sale_id=<?=$_POST['sale_id']?>" style="color: #111; text-decoration: none; background-color: #CCC; padding: 5px; border:1px solid #eee; font-weight: bold;"><?= ($i + 1); ?></a></li> -->
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
    <?php



            //*************




        })->setName('listarprodutoshasid/:hasid');

        
        
        
        
        
        
        //Listar produtos com limit e offset
        $app->get('/listarprodutos/:limit/:offset', function ($limit, $offset) {
            $dao = new DaoProducts();
            $dao->listAlLProducts($limit, $offset);
        })->setName('listarprodutos/:limit/:offset');
        //Inserir produto redireciona para a controller que insere



        $app->post('/inserirproduto', function () use($app) {

            ini_set( 'display_errors', '0' );
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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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


        //Edita produto
        $app->get('/editaproduto', 'usuarioLogado', function () {
           // $app->response->headers->set('Content-Type', 'application/json');

           // ini_set( 'display_errors', '1' ); 
            $idProduto = $_GET['id_produto'];

            $produto = json_decode(file_get_contents("http://tzne.kwcraft.com.br/admin/api/produtos/listarprodutos/".$idProduto));
           // $produto = file_get_contents("http://tzne.kwcraft.com.br/admin/api/produtos/listarprodutos/".$idProduto);
            //Como acessar o objeto produto
/*            echo "<pre>";
            echo var_dump($produto);
            echo "</pre>";*/

          //  echo $produto->status;


             $status;
                        if($produto->status==0){
                            $status ="Desativado";
                        }else{
                            $status = "Ativo";
                        }




?>

      

<html lang="en"><head>
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">

<title>TZNE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                        <style type="text/css"></style>
                        <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
                        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
                        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
                        <script type="text/javascript"></script>
                                    <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
                                <h1 class="section-header"><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s"> Editar Produto</span></h1>
                                <h3></h3>
                            </div>
                            <!--            <div class="contact-section">-->
                            <div class="container">
                                <form enctype="multipart/form-data" id="form" name="form" method="POST" action="http://tzne.kwcraft.com.br/Controller/AtualizaProduto.php">

                                    <?php
    /*Aqui envio ele pelo formulário para saber se quando receber será a ação do mesmo formulário, para evitar
    vários cliques de enviado e gerar duplicidade de chamados por cliques reptidos. 
    */
    echo "<input type=hidden name='seed' value='$seed'>";

    ?>

    <div class="col-md-6 form-line">
      <div class="form-group">
            <label for="name">Id do produto</label>
            <input disabled type="text" class="form-control" id="txtnome" name="product_id" placeholder=" Nome do produto" value="<?php echo $produto->id?>">
        </div>
        <div class="form-group">
            <label for="name">Nome do produto</label>
            <input type="text" class="form-control" id="txtnome" name="name" placeholder=" Nome do produto" value="<?php echo $produto->name?>">
        </div>
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" class="form-control" id="txtnome" name="model" placeholder=" Modelo" value="<?php echo $produto->model?>">
        </div>

        <div class="form-group">
            <label for="description"> Descrição</label>
            <textarea class="form-control" rows="3" id="txtmsg" name="description" placeholder=" Descrição" ><?php echo $produto->description?>
            </textarea>
        </div>

        <div class="form-group">
            <label for="specification">Especificação</label>
            <textarea class="form-control" rows="3" id="txtmsg" name="specification" placeholder=" Especificação" ><?php echo $produto->specification?>
            </textarea>

        </div>

        <div class="form-group">
            <!-- <label for="code">Código</label> -->
            <input type="hidden" class="form-control" id="txtnome" name="code" placeholder=" Código" value="<?php echo $produto->code?>">
        </div>

        <div class="form-group">
            <label for="sale_price">Preço de venda</label>
            <input type="text" class="form-control" id="txtnome" name="sale_price" placeholder=" Preço de venda" value="<?php echo $produto->purchase_price?>">
        </div>

        <div class="form-group">
            <label for="purchase_price">Preço de compra</label>
            <input type="text" class="form-control" id="txtnome" name="purchase_price" placeholder=" Preço de venda" value="<?php echo $produto->purchase_price?>">
        </div>


        <div class="form-group">
            <label for="profit_margin">Margem de lucro</label>
            <input type="text" class="form-control" id="txtnome" name="profit_margin" placeholder=" Margem de lucro" value="<?php echo $produto->profit_margin?>">
        </div>


        <div class="form-group">
            <label for="promotional_price">Preço promocional</label>
            <input type="text" class="form-control" id="txtemail" name="promotional_price" placeholder=" Preço promocional" value="<?php echo $produto->profit_margin?>">
        </div>  
        <div class="form-group">
            <label for="length">Comprimento</label>
            <input type="text" class="form-control" id="txttel" name="length" placeholder=" Comprimento" value="<?php echo $produto->length?>">
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="width">Largura</label>
            <input type="text" class="form-control" id="chamado" name="width" placeholder=" Largura" value="<?php echo $produto->width?>">
        </div>

        <div class="form-group">
            <label for="heigth">Altura</label>
            <input type="text" class="form-control" id="chamado" name="heigth" placeholder=" Altura" value="<?php echo $produto->heigth?>">
        </div>


        <div class="form-group">
            <label for="width">Status</label>
            <select class="form-control" name="status" required="required">
            
                 <option value="<?php echo $produto->status?>" selected><?php echo $status?></option>
                <option value="1">Ativar</option>
                <option value="0">Desativar</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product_stock_quantity">Quantidade em estoque </label>
            <input type="text" class="form-control" id="chamado" name="product_stock_quantity" value="<?php echo $produto->options[0]->productQuantity?>">
        </div>
        <div class="form-group">
            <!-- <label for="brands_brand_id">Marca</label> -->
            <input type="hidden" class="form-control" id="chamado" name="brands_brand_id" placeholder=" Marca" value="1">
        </div>
        <div class="form-group">
            <label for="departaments_departament_id">Departamento</label>
                 <label for="width">Tamanho</label>
            <select class="form-control" name="departaments_departament_id" required="required">

  <?php
                $departamentos = json_decode(file_get_contents("http://tzne.kwcraft.com.br/admin/api/listardepartamentos"));
/*                echo "<pre>";
                echo var_dump($departamentos);
                echo "<pre>";*/

                for($i=0; $i<sizeof($departamentos); $i++) {
                    $selected = '';
                    if($departamentos[$i]->departament_id == $produto->departaments_departament_id){
                print('<option value="'.$departamentos[$i]->departament_id.'"'.$selected.' selected>'.$departamentos[$i]->departament_name.'</option>'."\n");
                    }else
                    {
                    print('<option value="'.$departamentos[$i]->departament_id.'">'.$departamentos[$i]->departament_name.'</option>'."\n");
                    }
                }
                
            ?>
            </select>



        </div>

        <div class="form-group">
            <!-- <label for="idcolor">Cor</label> -->
            <input type="hidden" class="form-control" id="chamado" name="idcolor" placeholder=" Largura" value="2">
        </div>



        <div class="form-group">

                 <label for="width">Tamanho</label>
            <select class="form-control" name="idsize" required="required">
       
                   <?php
                $tamanhos = json_decode(file_get_contents("http://tzne.kwcraft.com.br/api/listadetamanhos"));

                for($i=0; $i<sizeof($tamanhos); $i++) {
                    $selected = '';
                    if($tamanhos[$i]->product_id_size == $produto->options[0]->size){
                print('<option value="'.$tamanhos[$i]->product_id_size.'"'.$selected.' selected>'.$tamanhos[$i]->product_size.'</option>'."\n");
                    }else
                    {
                    print('<option value="'.$tamanhos[$i]->product_id_size.'"'.$selected.'>'.$tamanhos[$i]->product_size.'</option>'."\n");
                    }
                }
                
            ?>



<!--                  <option value="<?php echo $produto->status?>" selected><?php echo $status?></option>
 -->       
            </select>


        </div>

<!--         <div class="form-group">
            <label for="img_relative_url">URL da imagem</label>
            <input type="text" class="form-control" id="chamado" name="img_relative_url" placeholder=" Largura">
        </div> -->

<!--         <div class="form-group">
            <label for="foto">Imagem</label>
            <input  type="file" class="form-control-file" idaria-describedby="fileHelp" name="foto" value="">
        </div> -->





        <div>

            <button type="submit" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Enviar</button>
              <a href="http://tzne.kwcraft.com.br/admin/api/produtos/listarprodutos" style="margin-bottom: 20px" class="btn btn-default danger"><i class="fa fa-reply" aria-hidden="true"></i>  Voltar</a>
        </div>

    </div>
</form>
</div>
<!--</div>-->
</section>
<script type="text/javascript">

</script>


    </body>
</html>





<?php



                    
        })->setName('/editaproduto');



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


 $app->get('/listardepartamentos', function () {
        $conn = new MysqlConn();
        $conn->Conecta();

        $query = "SELECT * FROM `departaments`";

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
    })->setName('/listardepartamentos');




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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>
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

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css">
            </style>
            <link rel="stylesheet" type="text/css" href="style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
                    <form id ="<?php echo $result[0]->id_protocol ?>" action = "/admin/atualizaprotocolos" method ="POST">
                        <div class="col-md-6 col-sm-offset-3 form-line">
                            <input  type = "hidden" name="id_protocol" value ="<?php echo $result[0]->id_protocol ?>">
                             <input  type = "hidden" name="assunto" value ="<?php echo $result[0]->short_description ?>">


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
                                <a href="http://tzne.kwcraft.com.br/admin/listarprotocolos?pagina=1" style="margin-bottom: 20px" class="btn btn-default danger"><i class="fa fa-reply" aria-hidden="true"></i>  Voltar</a>
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
            ini_set( 'display_errors', '1');

    $dao = new DaoHelpdesk();
    /* echo var_dump(intval($_POST['id_protocol']));
      echo var_dump(intval($_POST['protocol_status']));
      echo var_dump($_POST['resolved_by']);
      echo var_dump($_POST['solotion']); */

    $dao->updateProtocol(
            intval($_POST['id_protocol']), intval($_POST['protocol_status']), $_POST['resolved_by'], $_POST['solotion']);

    	include ROOT_DIR . '/View/Mailer/class.phpmailer.php';



            $mailer = new PHPMailer();
            $nome = $_POST['cliente'];
            $contato = $_POST['email'];
            $assunto = $_POST['assunto'];

           // echo var_dump($_POST);

            $mensagem = "Protocolo: ".$_POST['id_protocol']."
                         Assunto: ".$assunto."
                         Solução: ".$_POST['solotion']."
                            ";
   
            $mailer->IsSMTP();
            $mailer->SMTPDebug = 0;
            $mailer->CharSet = 'utf-8';
            $mailer->Port = 465; //Indica a porta de conexão para a saída de e-mails
            $mailer->Host = 'smtp.gmail.com'; //smtp.dominio.com.br
            $mailer->SMTPAuth = true; //define se haverá ou não autenticação no SMTP ssl://smtp.googlemail.com
            $mailer->SMTPSecure = 'ssl';
            $mailer->Username = 'contatotzne@gmail.com'; //Informe o e-mai o completo
            $mailer->Password = 'contatotzne123456'; //Senha da caixa postal
            $mailer->FromName = $assunto; //Nome que será exibido para o destinatário
            $mailer->From = 'contatotzne@gmail.com'; //Obrigatório ser a mesma caixa postal indicada em "username"
            $mailer->AddAddress(/* $destino, */$contato); //Destinatários
            $mailer->Subject = $assunto;
            $mailer->Body = $contato;
            $mailer->Body = $mensagem;
            
/*            echo "<pre>";
            echo var_dump($mailer);
            echo "</pre>";*/
            if($mailer->Send()){
                //echo true;
            }else{  
               // echo false;
            }


    
    
    
    
    ?>


    <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="robots" content="noindex, nofollow">

            <title>TZNE</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <style type="text/css"></style>
            <link rel="stylesheet" type="text/css" href="style.css">
            <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script type="text/javascript"></script>
            <script type=”text/javascript” src=”http://tzne.kwcraft.com.br/admin/javascripts.js”></script>

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
                        <div class="alert alert-success col-xs-6 col-md-offset-3" role="alert">Chamado atualizado com sucesso!</div>

                        <div class="col-xs-12">
                            <a  class="btn btn-info" href="http://tzne.kwcraft.com.br/admin/listarprotocolos">Voltar a lista de chamados</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        })->setName('atualizaprotocolos');
        
        
        
        

//        $app->post('/atualizaprotocolos', function () {
//            $dao = new DaoHelpdesk();
//            /* echo var_dump(intval($_POST['id_protocol']));
//              echo var_dump(intval($_POST['protocol_status']));
//              echo var_dump($_POST['resolved_by']);
//              echo var_dump($_POST['solotion']); */
//
//            $dao->updateProtocol(
//                    intval($_POST['id_protocol']), intval($_POST['protocol_status']), $_POST['resolved_by'], $_POST['solotion']);
//            echo ' <a href="http://tzne.kwcraft.com.br/listarprotocolos">Voltar a lista de chamados</a> ';
//        })->setName('atualizaprotocolos');

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

                function clienteLogado() {

            if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }
            if (!isset($_SESSION["cliente"])) {
                //Resgato uma instância existente de Slim
                $app = \Slim\Slim::getInstance();
                $app->flash('error', 'Login required');
//        $app->response->headers->set('Content-Type', 'aplication/json');
                $json = array('logado' => false);
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

                $app->get('/echosession',  function () use ($app) {
//         ini_set('display_errors', 1);       
            
    session_id("ahodm1ikfaa8g77s2ttrbi6g21");
                    if (!isset($_SESSION)) {
                session_start();
            } else {
                //echo"ja tem sessao";
            }
            echo "<pre>";
           echo var_dump($_SESSION);
            echo "</pre>";
            
           // session_id("8vqq7sjutad580sk45m2140vi4");

echo $_SESSION['cliente'];


        });
        
        $app->get('/jwt', function () use ($app) {
require_once ROOT_DIR . '/Services/JWT.php';
        $token = array();
        $token['id'] = 1235;
        echo JWT::encode($token, 'secret_server_key');
        
})->setName('jwt');
        
        
//$data = json_decode($app->request->getBody());
        $app->run();
        ?>
