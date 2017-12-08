<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoSale
 *
 * @author Willian Vieira
 */
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once "MysqlConn.php";
require_once ROOT_DIR . '/Model/Sale.php';
require_once ROOT_DIR . '/Model/SalesItens.php';

class DaoSale {

    function insertSale(Sale $sale) {
        //echo json_encode($sale);
        //echo $sale->getClientClientId();
        //echo var_dump($sale);

        $conn = new MysqlConn();
        $conn->Conecta();
        $lastId;



//                            echo $sale->getClientClientId();
//                            echo $sale->getTotalPartial(); 
//                            echo $sale->getAmount();
//                            echo $sale->getDiscount();
//                            echo $sale->getTypeFreight();
//                            echo $sale->getValueFreight();
//                            echo $sale->getNumberPlots();



        $q = "INSERT INTO "
                . "`sales` ("
                . "`sale_id`, "
                . "`client_client_id`, "
                . "`total_partial`, "
                . "`amount`, "
                . "`discount`, "
                . "`type_freight`, "
                . "`value_freight`, "
                . "`number_plots`) "
                . "VALUES (NULL,
                    " . $sale->getClientClientId() . ", 
                    " . $sale->getTotalPartial() . ", 
                    " . $sale->getAmount() . ", 
                    " . $sale->getDiscount() . ", 
                   \"" . $sale->getTypeFreight() . "\", 
                    " . $sale->getValueFreight() . ", 
                    " . $sale->getNumberPlots() . ")";





        try {

            //Tenta inserir a venda:

            mysqli_autocommit(false);
            mysqli_begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

            if (mysqli_query($conn->getLink(), $q)) {
                //if (true) {
                //Recupera o id da ultima venda iserida
                $lastId = mysqli_insert_id($conn->getLink());
                //Armazendo o array de itens
                $arraySaleItem[] = new SalesItens();
                $arraySaleItem = $sale->getSalesItens();
                // echo var_dump($arraySaleItem);
                //Laço para inserir item a item na tabela itens de venda
                //echo var_dump($arraySaleItem[0]['quantity']);
                for ($i = 0; $i < sizeof($sale->getSalesItens()); $i++) {
                    $querySaleItem = "
                    INSERT INTO `item_for_sale` (
                    `item_for_sale_id`, 
                    `sale_id_sale`, 
                    `product_product_has_id`, 
                    `quantity`, 
                    `subtotal`) 
                    VALUES (NULL, 
                    " . $lastId . ", "
                            . "" . $arraySaleItem[$i]['productProductHasId'] . ", "
                            . "" . $arraySaleItem[$i]['quantity'] . ","
                            . "" . $arraySaleItem[$i]['subtotal'] . ");";

                    if (mysqli_query($conn->getLink(), $querySaleItem)) {
                        
                    } else {
                        echo var_dump(mysqli_error($conn->getLink()));
                    }
                }
                date_default_timezone_set("America/Sao_Paulo");
                $date = date('Y-m-d H:i:s');
                //Query que isere o status do pedido
                $queryOrderStatus = "
                        INSERT INTO `sale_has_order_status` (
                        `sale_has_order_status_id`, 
                        `sales_sale_id`, 
                        `order_status_order_status_id`,
                         `date`, `informed_cli`, 
                         `comment`) 
                          VALUES (NULL, 
                            " . $lastId . ", 
                          '1', 
                          '" . $date . "', 
                          '1', 
                          'Pedido aguardando aprovação.');";
                if (mysqli_query($conn->getLink(), $queryOrderStatus)) {
                    mysqli_commit();
                    $conn->Desconecta();


                    //$json = "{'vendainserida':'true'}";
                    $json = $sale->serializeSale();

                    echo json_encode($json);
                    //listSalesById($lastId);

                }
            } else {
                echo var_dump(mysqli_error($conn->getLink()));
                $conn->Desconecta();
                $json = "{'vendainserida':'false'}";
                echo json_encode($json);
            }
        } catch (Exception $ex) {
            //                       echo var_dump(mysqli_error($conn->getLink())); 
            mysqli_rollback();
            $conn->Desconecta();
            $json = "{'vendainserida':'false'}";
            echo json_encode($json);
        }
    }

    function listSalesStatus() {

        $conn = new MysqlConn();
        $conn->Conecta();

        $query = "SELECT sale_id,
                 client_client_id, 
                 client_name,
                amount, 
                number_plots, 
                sale_has_order_status.order_status_order_status_id,
                  order_status.name, date FROM `sales` 
                  inner JOIN sale_has_order_status 
                  on sale_id = sale_has_order_status.sales_sale_id 
                  INNER join order_status 
                  ON sale_has_order_status.order_status_order_status_id = order_status.order_status_id
                  INNER JOIN client
                  ON client.client_id = client_client_id";

        try {
            if ($result = mysqli_query($conn->getLink(), $query)) {

                $json = array();
                $cont =0;
                while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json

                    $json[$cont]['venda'] = $row;
                   // echo $json[$cont]['venda']['sale_id']."<br>";
                            $q = "SELECT * FROM `item_for_sale` WHERE `sale_id_sale` = ".$json[$cont]['venda']['sale_id'];
                              //  echo var_dump($json);
                                    $result1 = mysqli_query($conn->getLink(), $q);
                                    $c=0;
                                    while ($nrow = mysqli_fetch_assoc($result1)) {

                                        $itens = json_decode(file_get_contents("http://tzne.kwcraft.com.br/api/produtos/listarprodutoshasid/".$nrow['product_product_has_id']));

                               /*        echo "<pre>";
                                       echo var_dump($itens);
                                       echo "<pre>";*/
                                        //armazena linha em cada posição do array json
                                                $itensCliente = json_decode(file_get_contents("http://tzne.kwcraft.com.br/api/venda/listaitensvendas/".$json[$cont]['venda']['sale_id']));
                                        $json[$cont]['venda'][$c]['itens']['id'] = $itens->id;
                                        $json[$cont]['venda'][$c]['itens']['name'] = $itens->name;
                                        $json[$cont]['venda'][$c]['itens']['purchase_price'] = $itens->purchase_price;
                                        $json[$cont]['venda'][$c]['itens']['quantity'] = $itensCliente[$c]->quantity;
                                        $json[$cont]['venda'][$c]['itens']['img'] = $itens->img_relative_url;
                                        //$json[$cont]['venda'][$c]['itens']['nome'] = $itens->nome;
                                    /*        echo "<pre>";
                                       echo var_dump($itensCliente);
                                       echo "<pre>";*/

                                        $c++;




                                     }      


                
                            $cont++;
                }
/*                echo "<pre>";
                echo var_dump($json);
                echo "<pre>";*/
                return json_encode($json);
            }
        } catch (Exception $ex) {
            
        }
    }

    function updateStatusSale($idProtocol, $status) {
        $conn = new MysqlConn();
        $conn->Conecta();


        //$query = "UPDATE `helpdesk_protocols` SET protocol_status = ".$status. "WHERE id_protocol = " . $idProtocol.";";
        $query = "UPDATE `sale_has_order_status` SET `order_status_order_status_id`= " . $status . " WHERE `sales_sale_id` = " . $idProtocol;
        $query = "UPDATE `sale_has_order_status` SET `order_status_order_status_id`= " . $status . " WHERE `sales_sale_id` = " . $idProtocol;

        if (mysqli_query($conn->getLink(), $query)) {
            $json = "{'pedidoatualizado':'true'}";
            echo json_encode($json);
        } else {
            //  echo var_dump(mysqli_error($conn->getLink()));
            $json = "{'pedidoatualizado':'false'}";
            echo json_encode($json);
        }
    }

    /*
      function updateStatusSale($orderStatusId, $salesSaleId){

      $conn = new MysqlConn();
      $conn->Conecta();

      $query = "UPDATE "
      . "`sale_has_order_status` "
      . "SET `order_status_order_status_id`= {$orderStatusId} "
      . "WHERE sale_has_order_status.sales_sale_id = {$salesSaleId}";

      try{
      if($result = mysqli_query($conn->getLink(), $query)){

      return true;
      }else{
      return false;
      }
      } catch (Exception $ex) {

      }
      } */







 function listSalesById($idvenda) {

        $conn = new MysqlConn();
        $conn->Conecta();

            $query =  "SELECT sale_id, client_name, client_client_id,order_status_order_status_id, order_status.name,
                date,  amount, discount,
                total_partial, number_plots, subtotal FROM `sales`
                    INNER JOIN sale_has_order_status
                    ON sale_has_order_status.sales_sale_id =sales.sale_id
                    INNER JOIN item_for_sale
                    ON item_for_sale.sale_id_sale = sales.sale_id
                     INNER JOIN client
                    ON sales.client_client_id = client.client_id
                    INNER JOIN  order_status
                    ON order_status.order_status_id = sale_has_order_status.order_status_order_status_id
                    WHERE sale_id = ".$idvenda."
                    GROUP by sales.sale_id;";

                    if ($result = mysqli_query($conn->getLink(), $query)) {
                        $json = array();
                        while ($row = mysqli_fetch_assoc($result)) {

                //armazena linha em cada posição do array json

                            $json[] = $row;
                        }

                        echo json_encode($json);
                        return json_encode($json);
                    } else {
                        echo var_dump(mysqli_error($conn->getLink()));

                        return false;
                    }




}


    function listSales() {

        $conn = new MysqlConn();
        $conn->Conecta();

            $query = ""
            . "SELECT sale_id, client_name, client_client_id,order_status_order_status_id, order_status.name,
                date,  amount, discount,
                total_partial, number_plots, subtotal FROM `sales`
                    INNER JOIN sale_has_order_status
                    ON sale_has_order_status.sales_sale_id =sales.sale_id
                    INNER JOIN item_for_sale
                    ON item_for_sale.sale_id_sale = sales.sale_id
                     INNER JOIN client
                    ON sales.client_client_id = client.client_id
                    INNER JOIN  order_status
                    ON order_status.order_status_id = sale_has_order_status.order_status_order_status_id
                    GROUP by sales.sale_id";


        if ($result = mysqli_query($conn->getLink(), $query)) {
            $json = array();
            while ($row = mysqli_fetch_assoc($result)) {

                //armazena linha em cada posição do array json

                $json[] = $row;
            }

           
            return json_encode($json);
        } else {
            echo var_dump(mysqli_error($conn->getLink()));

            return false;
        }
    }
    
    function listItensSaleById($id){
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
                    return json_encode($json);
                }
            }

    }

}
