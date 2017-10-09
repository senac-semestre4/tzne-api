<?php

/**
 * Description of DaoProducts
 *
 * @author Willian Vieira
 */
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 



$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once "MysqlConn.php";
require_once ROOT_DIR."/Model/Product.php";

//Dao responsável pelo CRUD de produto
class DaoProducts {

    
    //Insere produto
    public function insertProduct(Product $product) {
        //Instância o objeto conexão
        $conn = new MysqlConn();
        //Conecta
         $conn->Conecta(); //cria conexão
        
        try {

           // echo $product->getStatus();
            // preparando o stmt
            $stmt = mysqli_prepare($conn->getLink(), ""
                    . "INSERT INTO `products` 
                        (`product_id`, 
                        `product_name`, 
                        `product_model`, 
                        `product_code`, 
                        `product_specification`, 
                        `product_departament`, 
                        `product_purchase_price`, 
                        `product_profit_margin`, 
                        `product_promotional_price`, 
                        `product_length`, 
                        `product_width`, 
                        `product_heigth`, 
                        `product_stock_quantity`, 
                        `product_img_relative_url`, 
                        `product_status`, 
                        `brands_brand_id`, 
                        `departaments_departament_id`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    

            /*
             * bind_param =  Deve passar para o mysql o tipo do dado que está sendo enviado
             * conforme tabela abaixo:
             * Caractere	Descrição
              i	corresponde a uma variável de tipo inteiro
              d	corresponde a uma variável de tipo double
              s	corresponde a uma variável de tipo string
              b	corresponde a uma variável que contém dados para um blob e enviará em pacotes
             * 
             */
            var_dump(mysqli_error($conn->getLink()));  
            $id= null;
            $stmt->bind_param("ississddddddisbii",
                    $id,
                    $product->getName(), 
                    $product->getModel(), 
                    $product->getCode(), 
                    $product->getSpecification(), 
                    $product->getDepartament(), 
                    $product->getPurchase_price(), 
                    $product->getProfit_margin(), 
                    $product->getPromotional_price(), 
                    $product->getLength(), 
                    $product->getWidth(), 
                    $product->getHeigth(), 
                    $product->getStock_quantity(), 
                    $product->getImg_relative_url(), 
                    $product->getStatus(), 
                    $product->getBrands_brand_id(),
                    $product->getDepartaments_departament_id());
            
            //Executa o comando de inserção
           
           if( !$stmt->execute()){
                 var_dump(mysqli_error($conn->getLink()));  
               
           }
           
                $stmt->close();
                $conn->Desconecta();
           
        } catch (Exception $ex) {
                $stmt->close();
                $conn->Desconecta();
        }
    }
    
    
    //Listar por ID do produto
     public function listByID($id){
       //Criando a conexão e conectando
        $conn = new MysqlConn();
        $conn->Conecta();
        
        /*$json;
         * Variavel será usada para receber o resultado da query 
         * para o formato json
         */
        $json;
        
        
        /*
         *  Se o resultado da query for armazenado na variável $result
         * $json receberá o resultado
         */
              $query = "SELECT * FROM products WHERE product_id =" . $id;

        if ($result = mysqli_query($conn->getLink(), $query)) {

            $json= mysqli_fetch_assoc($result);
            
            mysqli_free_result($result);
            
            $conn->Desconecta();
             echo json_encode($json);
            
             return $json;
        }else{
           // echo var_dump(mysqli_error($conn->getLink()));  

            $conn->Desconecta();
            return false;
        }
        
    }
    
    
    
    
    
    public function listAlLProducts() {
        $conn = new MysqlConn();
        $conn->Conecta();

        /*$json 
         * Array que terá o resultado de > "Select * from products"
         */
        
        $json = array();
        
        $result = mysqli_query($conn->getLink(), "Select * from products");

        /*While
         * Enquanto haver linhas da tabela para ser
         * lida, essas serão armazenadas na row
         */
        while ($row = mysqli_fetch_assoc($result)) {
            
            //armazena linha em cada posição do array json
            $json[] = $row;
        }
        
        $conn->Desconecta();

        echo json_encode($json);

       }

    
    /*Remove produto do banco por ID
     * 
     */
    public function removeByID($id){
        $conn = new MysqlConn();
        $conn->Conecta();
       //Executa a query recebendo o parametro do produto que será deletado
        if(mysqli_query($conn->getLink(), "DELETE FROM products WHERE product_id = ".$id. " LIMIT 1")){
            echo var_dump(mysqli_error($conn->getLink()));
            $conn->Desconecta();
            return true;
        }else {
            echo var_dump(mysqli_error($conn->getLink()));

            $conn->Desconecta();
            return false;
        }
        
    }
    
    /*
     * Atualiza produto no banco
     * Recebe  um produto do Front-end para ser atualizado no banco.
     */
public function updateProduct(Product $product) {

        $conn = new MysqlConn();

        $conn->Conecta(); //cria conexão

        try {

            // preparando o stmt
            $stmt = mysqli_prepare($conn->getLink(), ""
                    . "UPDATE `products` "
                    . "SET "
                    . "`product_name` = ?, "
                    . "`product_model` = ?, "
                    . "`product_code` = ?, "
                    . "`product_specification` = ?, "
                    . "`product_departament` = ?, "
                    . "`product_purchase_price` = ?, "
                    . "`product_profit_margin` = ?, "
                    . "`product_promotional_price` = ?, "
                    . "`product_length` = ?, "
                    . "`product_width` = ?, 
                        `product_heigth` = ?, 
                        `product_stock_quantity` = ?, 
                        `product_img_relative_url` = ?, 
                        `product_status` = ?, 
                        `brands_brand_id` = ?, 
                        `departaments_departament_id` = ?
                        WHERE `products`.`product_id` = ?");

            var_dump(mysqli_error($conn->getLink()));  

            /*
             * bind_param =  Deve passar para o mysql o tipo do dado que está sendo enviado
             * conforme tabela abaixo:
             * Caractere	Descrição
              i	corresponde a uma variável de tipo inteiro
              d	corresponde a uma variável de tipo double
              s	corresponde a uma variável de tipo string
              b	corresponde a uma variável que contém dados para um blob e enviará em pacotes
             * 
             */
            $stmt->bind_param("ssissddddddisbiii",
                    
                    $product->getName(), 
                    $product->getModel(), 
                    $product->getCode(), 
                    $product->getSpecification(), 
                    $product->getDepartament(), 
                    $product->getPurchase_price(), 
                    $product->getProfit_margin(), 
                    $product->getPromotional_price(), 
                    $product->getLength(), 
                    $product->getWidth(), 
                    $product->getHeigth(), 
                    $product->getStock_quantity(), 
                    $product->getImg_relative_url(), 
                    $product->getStatus(), 
                    $product->getBrands_brand_id(),
                    $product->getDepartaments_departament_id(),
                    $product->getId());

            $stmt->execute();
            //echo$stmt->affected_rows;
            $stmt->close();
            $conn->Desconecta();
        
            
        } catch (Exception $ex) {
            $conn->Desconecta();
        }
    }    
    
    
    
    
    
    
    
    
}

?>

