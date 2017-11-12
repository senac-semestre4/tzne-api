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
        
        

        $conn = new MysqlConn();
        $conn->Conecta();
        $lastId;

        $querySale = "INSERT INTO `sales` (
                    `sale_id`, 
                    `client_client_id`, 
                    `total_partial`, 
                    `amount`, 
                    `discount`, 
                    `type_freight`, 
                    `value_freight`, 
                    `number_plots`) 
                    VALUES (NULL, ".$sale->getClientClientId() .", ". $sale->getTotalPartial() . "," . $sale->getAmount() . ","  . $sale->getDiscount() . ",".  $sale->getTypeFreight() . ", " .  $sale->getValueFreight() . ", " . $sale->getNumberPlots() . ");";

        $q="INSERT INTO "
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
                    ".$sale->getClientClientId().", 
                    ".$sale->getTotalPartial().", 
                    ".$sale->getAmount().", 
                    ".$sale->getDiscount().", 
                   \"".$sale->getTypeFreight()."\", 
                    ".$sale->getValueFreight().", 
                    ".$sale->getNumberPlots().")";
        
        echo $q;
        
        
        
        
        try {
            
            //Tenta inserir a venda:
            if (mysqli_query($conn->getLink(), $q)) {
                
                //Recupera o id da ultima venda iserida
                $lastId = mysqli_insert_id($conn->getLink());
                //Armazendo o array de itens
                $arraySaleItem = new SalesItens();
                $arraySaleItem = $sale->getSalesItens();
                //Laço para inserir item a item na tabela itens de venda
                for ($i = 0; $i < sizeof($sale->getSalesItens()); $i++) {
                    $querySaleItem = "
                    INSERT INTO `item_for_sale` (
                    `item_for_sale_id`, 
                    `sale_id_sale`, 
                    `product_product_has_id`, 
                    `quantity`, 
                    `subtotal`) 
                    VALUES (NULL, 
                    ".$lastId.", "
                    . "".$arraySaleItem[$i]->getProductProductHasId().", "
                    . "".$arraySaleItem[$i]->getQuantity().","
                    . " ".$arraySaleItem[$i]->getSubtotal().");";
                    
                    if(mysqli_query($conn->getLink(), $querySaleItem)){
                        echo "produto inserido";
                    }else{
                          echo var_dump(mysqli_error($conn->getLink())); 
                    }
                    
                }
                //Query que isere o status do pedido
                $queryOrderStatus = "
                        INSERT INTO `sale_has_order_status` (
                        `sale_has_order_status_id`, 
                        `sales_sale_id`, 
                        `order_status_order_status_id`,
                         `date`, `informed_cli`, 
                         `comment`) 
                          VALUES (NULL, 
                            ".$lastId.", 
                          '1', 
                          'NOW()', 
                          '1', 
                          'Pedido aguardando aprovação.');";
                if(mysqli_query($conn->getLink(), $queryOrderStatus)){
                    
                }
                
            } else {
                echo var_dump(mysqli_error($conn->getLink())); 
                //echo "erro";
            }
        } catch (Exception $ex) {
            
        }


        
    }

    function listSalesStatus(){
        
        $conn = new MysqlConn();
        $conn->Conecta();
        
        $query = "SELECT sale_id,"
                . " client_client_id, "
                . "amount, "
                . "number_plots, "
                . "sale_has_order_status.order_status_order_status_id,
                  order_status.name FROM `sales` 
                  inner JOIN sale_has_order_status 
                  on sale_id = sale_has_order_status.sales_sale_id 
                  INNER join order_status 
                  ON sale_has_order_status.order_status_order_status_id = order_status.order_status_id";
        
        try{
                if($result = mysqli_query($conn->getLink(), $query)){
                    
                    $json = array();
                      while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json
                    
                    $json[] = $row;
              
                      }
                     
                    return json_encode($json);
                }
        } catch (Exception $ex) {

        }
    }
    
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
    }
    
}
