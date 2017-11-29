<?php
               ini_set('display_errors', 0);

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

    
    //
    public function insertProduct(Product $product,  $options) {
        
    
        
        //Instância o objeto conexão
        $conn = new MysqlConn();
        //Conecta
         $conn->Conecta(); //cria conexão
        
         
            //Antes de inserir o produto, verifico se ele já está na 
            //tabela products, usando o método listProductByCaracteristics
         
          // Armazena os indices dos produtos com características que
         //não contém no banco
          $indice = array();
          //Se o id é não é nulo, segue  a verificação 

        //  echo $product->getId();
          
          if ($product->getCode() != null) {
              
            for ($i = 0; $i < sizeof($options); $i++) {

                   if ($this->listProductByCaracteristicsCode($product->getCode(), $options[$i]->getColor(), $options[$i]->getSize())== false) {
                       
                    array_push($indice, $i);
                    echo"<indice>";
                    echo $indice[$i];
                    echo"<indice>";
                    
                }
                
            }
            
         goto tentar;
           
        
                   } else if($product->getId() == null){
                       
                       goto inserir;
                       
                        
        try {

         tentar:
           //  echo "tentar";
            // preparando o stmt
         
         
         if($options[$indice[0]] == null){
           //  echo "indice nulo";

            $obj->Resposta = "Produto existente";

            $json = json_encode($obj, JSON_PRETTY_PRINT);
            
            echo $json;
          
         }else{
             
             inserir:
            $stmt = mysqli_prepare($conn->getLink(), 
                                    "INSERT INTO `products` (
                                    `product_id`,
                                    `product_name`,
                                    `product_model`,
                                    `product_code`,
                                    `product_specification`,
                                    `product_purchase_price`,
                                    `product_profit_margin`,
                                    `product_promotional_price`,
                                    `product_length`,
                                    `product_width`,
                                    `product_heigth`,
                                    `product_img_relative_url`,
                                    `product_status`,
                                    `brands_brand_id`,
                                    `departaments_departament_id`, 
                                    `product_description`, 
                                    `product_price_sale`) 
                                    VALUES (
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?)");
                    

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
            
            $id= null;
            $stmt->bind_param("issisddddddsiiisd",
                    $id,
                    $product->getName(), 
                    $product->getModel(), 
                    $product->getCode(), 
                    $product->getSpecification(), 
                    $product->getPurchase_price(), 
                    $product->getProfit_margin(), 
                    $product->getPromotional_price(), 
                    $product->getLength(), 
                    $product->getWidth(), 
                    $product->getHeigth(), 
                    $product->getImg_relative_url(), 
                    $product->getStatus(), 
                    $product->getBrands_brand_id(),
                    $product->getDepartaments_departament_id(),
                    $product->getDescription(),
                    $product->getSalePrice());
            
            //Executa o comando de inserção
           
           if($stmt->execute()){
                 var_dump(mysqli_error($conn->getLink()));  
                 
                 
                 $lastId = mysqli_insert_id($conn->getLink());
                 echo"<br>";
                 echo"Last id  ";
                 echo$lastId;
                 echo"<br>";
                 
                 
                 if (isset($indice[0])) {



                            for ($i = 0; $i < sizeof($options); $i++) {

                                echo "<br>";
                               // echo $options[$i]->getSize();
                                echo "<br>";
                                //echo $options[$i]->getSize();
                                echo "<br>";
                                echo var_dump($options);
                                $query = "INSERT INTO `products_has_products_size_color_qtd` (
                            `products_product_id`,
                             `products_size_product_id_size`,
                             `products_color_product_id_color`,
                             `product_quantity`) VALUES (" . $lastId . ",
                             " . $options[$indice[$i]]->getSize() . ",
                             " . $options[$indice[$i]]->getColor() . ",
                             " . $options[$indice[$i]]->getProductQuantity() . ")";

                                if (mysqli_query($conn->getLink(), $query)) {
                                    echo "inserido";
                                } else {
                                    var_dump(mysqli_error($conn->getLink()));
                                }
                            }
                        } else {

                            for ($i = 0; $i < sizeof($options); $i++) {

                                echo "<br>";
                                echo $options[$i]->getSize();
                                echo "<br>";
                                echo $options[$i]->getSize();
                                echo "<br>";
                                $query = "INSERT INTO `products_has_products_size_color_qtd` (
                            `products_product_id`,
                             `products_size_product_id_size`,
                             `products_color_product_id_color`,
                             `product_quantity`) VALUES (" . $lastId . ",
                             " . $options[$i]->getSize() . ",
                             " . $options[$i]->getColor() . ",
                             " . $options[$i]->getProductQuantity() . ")";

                                if (mysqli_query($conn->getLink(), $query)) {
                                    echo "inserido";
                                } else {
                                    var_dump(mysqli_error($conn->getLink()));
                                }
                            }
                        }
                    }else{
                                                            var_dump(mysqli_error($conn->getLink()));

                    }

                    $stmt->close();
                $conn->Desconecta();
         }  
        } catch (Exception $ex) {
                $stmt->close();
                $conn->Desconecta();
        }
  }  else {
            ini_set('display_errors', 0);

            $obj->Resposta = "Produto existente";

            $json = json_encode($obj, JSON_PRETTY_PRINT);
            
            echo $json;
            return false;
     }
   }
    
    
    //Listar por ID do produto
     public function listById($id){
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
              $query = "SELECT * FROM `products_has_products_size_color_qtd`
                        INNER JOIN products
                        on products.product_id = products_has_products_size_color_qtd.products_product_id
                        WHERE `products_product_id` = ".$id;

        if ($result = mysqli_query($conn->getLink(), $query)) {

            
            if(!mysqli_num_rows($result)){
                echo "Sem resultado";
            }else{
               $p = new Product();
                while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json
                    
                    $json[] = $row;
               
                    $p->setHasId($row['product_has_id']);
                    $p->setId($row['product_id']);
                    $p->setName($row['product_name']);
                    $p->setModel($row['product_model']);
                    $p->setCode($row['product_code']);
                    $p->setSpecification($row['product_specification']);
                    $p->setPurchase_price($row['product_purchase_price']);
                    $p->setProfit_margin($row['product_profit_margin']);
                    $p->setPromotional_price($row['product_promotional_price']);
                    $p->setLength($row['product_length']);
                    $p->setWidth($row['product_width']);
                    $p->setHeigth($row['product_heigth']);
                    $p->setProductQuantity($row['product_quantity']);
                    $p->setImg_relative_url($row['product_img_relative_url']);
                    $p->setStatus($row['product_status']);
                    $p->setBrands_brand_id($row['brands_brand_id']);
                    $p->setDepartaments_departament_id($row['departaments_departament_id']);
                    $p->setSize($row['products_size_product_id_size']);
                    $p->setColor($row['products_color_product_id_color']);
                }
                //echo var_dump(mysqli_error($conn->getLink()));  
                $conn->Desconecta();
                
                
                //echo json_encode($json);
                
                    return $p;
            }
        }else{
           //echo var_dump(mysqli_error($conn->getLink()));  

            $conn->Desconecta();
            return false;
        }
        
    }
    
     public function listByasId($hasId){
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
              $query = "SELECT * FROM "
                      . "`products_has_products_size_color_qtd` "
                      . "INNER JOIN products "
                      . "on products.product_id = products_has_products_size_color_qtd.products_product_id "
                      . "WHERE products_has_products_size_color_qtd.product_has_id = " . $hasId;

        if ($result = mysqli_query($conn->getLink(), $query)) {

            
            if(!mysqli_num_rows($result)){
                echo "Sem resultado";
            }else{
               $p = new Product();
                while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json
                    
                    $json[] = $row;
               
                    $p->setHasId($row['product_has_id']);
                    $p->setId($row['product_id']);
                    $p->setName($row['product_name']);
                    $p->setModel($row['product_model']);
                    $p->setCode($row['product_code']);
                    $p->setSpecification($row['product_specification']);
                    $p->setPurchase_price($row['product_purchase_price']);
                    $p->setProfit_margin($row['product_profit_margin']);
                    $p->setPromotional_price($row['product_promotional_price']);
                    $p->setLength($row['product_length']);
                    $p->setWidth($row['product_width']);
                    $p->setHeigth($row['product_heigth']);
                    $p->setProductQuantity($row['product_quantity']);
                    $p->setImg_relative_url($row['product_img_relative_url']);
                    $p->setStatus($row['product_status']);
                    $p->setBrands_brand_id($row['brands_brand_id']);
                    $p->setDepartaments_departament_id($row['departaments_departament_id']);
                    $p->setSize($row['products_size_product_id_size']);
                    $p->setColor($row['products_color_product_id_color']);
                }
                //echo var_dump(mysqli_error($conn->getLink()));  
                $conn->Desconecta();
                
                
                //echo json_encode($json);
                
                    return $p;
            }
        }else{
           //echo var_dump(mysqli_error($conn->getLink()));  

            $conn->Desconecta();
            return false;
        }
        
    }
    
    
    
    /*
     * Recebe os parâmetros para buscar no banco
     * $codigo do produto
     * $idCor id da cor do produto
     * $idTam id do tamanho do produto
     * 
     */
    public function listProductByCaracteristics($id, $idCor, $idTam){
        
          //Criando a conexão e conectando
        $conn = new MysqlConn();
        $conn->Conecta();
        
        /*$json;
         * Variavel será usada para receber o resultado da query 
         * para o formato json
         */
        $json;
        
        
        
        $query = "SELECT *  FROM products_has_products_size_color_qtd
                INNER JOIN products
                on products_has_products_size_color_qtd.products_product_id = products.product_id
                WHERE `products_product_id` = ".$id."
                AND `products_size_product_id_size` = ".$idTam." 
                AND `products_color_product_id_color` = ".$idCor;
    
        
        
           
        
        
        //Tenta receber o resultado da execução da query
        if ($result = mysqli_query($conn->getLink(), $query)) {

                //Se não há linhas
            if(!mysqli_num_rows($result)){
                
                return false; // não há produtos
                
            }else{
                
                
            /*
             * Na Dao de inserir produto, é feito a verificação se o produto
             * com código, cor e tamanho já existem, sendo assim não há validações neste
             */
            //Passa o resultado em formato de array associativo
                $p = new Product();
                $options = new ProductOpitons();
                $arrayOptions =  array();

                $json= mysqli_fetch_assoc($result);
            
                    $p->setId($json['product_id']);
                    $p->setName($json['product_name']);
                    $p->setModel($json['product_model']);
                    $p->setCode($json['product_code']);
                    $p->setSpecification($json['product_specification']);
                    $p->setPurchase_price($json['product_purchase_price']);
                    $p->setProfit_margin($json['product_profit_margin']);
                    $p->setPromotional_price($json['product_promotional_price']);
                    $p->setLength($json['product_length']);
                    $p->setWidth($json['product_width']);
                    $p->setHeigth($json['product_heigth']);
                    $p->setProductQuantity($json['product_quantity']);
                    $p->setImg_relative_url($json['product_img_relative_url']);
                    $p->setStatus($json['product_status']);
                    $p->setBrands_brand_id($json['brands_brand_id']);
                    $p->setDepartaments_departament_id($json['departaments_departament_id']);
                    $p->setTshirtSize($json['products_size_product_id_size']);
                    $p->setTshirtColor($json['products_color_product_id_color']);

                    $options->setProductQuantity($json['product_quantity']);
                    $p->setSize($json['products_size_product_id_size']);
                    $p->setColor($json['products_color_product_id_color']);
                    $options->setSize($json['products_size_product_id_size']);
                    $options->setColor($json['products_color_product_id_color']);

                    
                    $arrayOptions[] = $options;
                    $p->setOptions($arrayOptions);      
             
                    
                    
            //Libera memória
            mysqli_free_result($result);
            
            $conn->Desconecta();
            //Configura o header para a indentificação do navegador
            header("Content-Type: application/json; charset=UTF-8");
            //Codifica em formado json e imprime
            
             //echo var_dump($p);
            
            
            // echo json_encode($p->serializeProduct());
              
             return $p;
            }
        }
//        else{
//            echo var_dump(mysqli_error($conn->getLink()));  
//
//            $conn->Desconecta();
//            return false;
//        }
//        
        
    }

    
    public function listProductByCaracteristicsCode($code, $idCor, $idTam){
        
          //Criando a conexão e conectando
        $conn = new MysqlConn();
        $conn->Conecta();
        
        /*$json;
         * Variavel será usada para receber o resultado da query 
         * para o formato json
         */
        $json;
        
        
        
        $query = "SELECT *  FROM products_has_products_size_color_qtd
                INNER JOIN products
                on products_has_products_size_color_qtd.products_product_id = products.product_id
                WHERE `product_code` = ".$code."
                AND `products_size_product_id_size` = ".$idTam." 
                AND `products_color_product_id_color` = ".$idCor;
    
        
        
           
        
        
        //Tenta receber o resultado da execução da query
        if ($result = mysqli_query($conn->getLink(), $query)) {

                //Se não há linhas
            if(!mysqli_num_rows($result)){
                
                return false; // não há produtos
                
            }else{
                
                
            /*
             * Na Dao de inserir produto, é feito a verificação se o produto
             * com código, cor e tamanho já existem, sendo assim não há validações neste
             */
            //Passa o resultado em formato de array associativo
                
            $json= mysqli_fetch_assoc($result);
            
            //Libera memória
            mysqli_free_result($result);
            
            $conn->Desconecta();
            //Configura o header para a indentificação do navegador
            header("Content-Type: application/json; charset=UTF-8");
            //Codifica em formado json e imprime
             echo json_encode($json);
            
             return true;
            }
        }
//        else{
//            echo var_dump(mysqli_error($conn->getLink()));  
//
//            $conn->Desconecta();
//            return false;
//        }
//        
        
    }

    
/*
 * Função que lista todos os produtos.
 * O parametro @limit é opcional, limita a quantidade de resultados
 */

    public function listAlLProducts($limit, $offset) {
        $conn = new MysqlConn();
        $conn->Conecta();

        /*$json 
         * Array que terá o resultado de > "Select * from products"
         */
        
        $json = array();
        
            
        if (!isset($limit) || $limit == null || !isset($offset) || $offset == null) {
            $query = "SELECT *  FROM products_has_products_size_color_qtd
                INNER JOIN products
                on products_has_products_size_color_qtd.products_product_id = products.product_id";
        } else {
            $query = "SELECT *  FROM products_has_products_size_color_qtd
                INNER JOIN products
                on products_has_products_size_color_qtd.products_product_id = products.product_id LIMIT " . $limit . "," . $offset;
        }

        $result = mysqli_query($conn->getLink(), $query);

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
public function updateProduct(Product $product, ProductOpitons $options) {

        $conn = new MysqlConn();

        $conn->Conecta(); //cria conexão

        try {

            
            
                    $query = "UPDATE `products` as prod
                    INNER join products_has_products_size_color_qtd as phas
                    ON prod.product_id = phas.products_product_id
                    SET 
                    `product_name`= ?,
                    `product_model`= ?,
                    `product_code`= ?,
                    `product_specification`= ?,
                    `product_purchase_price`= ?,
                    `product_profit_margin`= ?,
                    `product_promotional_price`= ?,
                    `product_length`= ?,
                    `product_width`= ?,
                    `product_heigth`= ?,
                    `product_img_relative_url`= ?,
                    `product_status`= ?,
                    `brands_brand_id`= ?,
                    `departaments_departament_id`= ?,
                    phas.product_quantity = ?,
                    phas.products_size_product_id_size = ?,
                    phas.products_color_product_id_color = ?
                    product_description =?,
                    product_price_sale =?
                    WHERE prod.product_id = ?;";             
            
            
            
            // preparando o stmt
            $stmt = mysqli_prepare($conn->getLink(), $query);
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
            $stmt->bind_param("ssisddddddsiiiiiiisd",
                    $product->getName(), 
                    $product->getModel(), 
                    $product->getCode(), 
                    $product->getSpecification(), 
                    $product->getPurchase_price(), 
                    $product->getProfit_margin(), 
                    $product->getPromotional_price(), 
                    $product->getLength(), 
                    $product->getWidth(), 
                    $product->getHeigth(), 
                    $product->getImg_relative_url(), 
                    $product->getStatus(), 
                    $product->getBrands_brand_id(),
                    $product->getDepartaments_departament_id(),
                    $options->getProductQuantity(),
                    $options->getSize(),
                    $options->getColor(), 
                    $product->getId(),
                    $product->getDescription(),
                    $product->getSalePrice());

            $stmt->execute();
            var_dump(mysqli_error($conn->getLink()));  

            //echo$stmt->affected_rows;
            $stmt->close();
            $conn->Desconecta();
            return true;
            
        } catch (Exception $ex) {
            $conn->Desconecta();
        
            return false;
            
        }
    }    
    
        public function listAlLDepartaments() {
        $conn = new MysqlConn();
        $conn->Conecta();

        /*$json 
         * Array que terá o resultado de > "Select * from products"
         */
        
        $json = array();
        
            
        
            $query = "SELECT * FROM departaments";
        

        $result = mysqli_query($conn->getLink(), $query);

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


     public function listProdDepartaments($departament) {
        $conn = new MysqlConn();
        $conn->Conecta();

        /*$json 
         * Array que terá o resultado de > "Select * from products"
         */
        
        $json = array();
        
            
        
            $query = "SELECT *  FROM products_has_products_size_color_qtd
                INNER JOIN products
                on products_has_products_size_color_qtd.products_product_id = products.product_id
                    WHERE departaments_departament_id = ".$departament;
        

        $result = mysqli_query($conn->getLink(), $query);
        //echo var_dump(mysqli_error($conn->getLink()));  
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
    
    
    
    
    
}

?>

