<?php


ini_set('display_errors', 0);
/*
 * Este arquivo juntei o php e html para facilitar a motagem do teste. 
 * Esse poderá ser usado como interface para cadastro de produtos
 */

//Verifica se o post vindo do name "code", no html, está vazio, 
//se não recebe os parâmetros e tenta inserir no banco
if($_POST['code']){
    
    $path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR.'/Dao/DaoProducts.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Product.php';
require_once ROOT_DIR.'/validacao.php';


$p = new Product();
$p->setId(null);
$p->setName($_POST['nome']); 
$p->setModel($_POST['model']); 
$p->setCode($_POST['code']); 
$p->setSpecification($_POST['specification']); 
$p->setPurchase_price($_POST['purchase_price']); 
$p->setProfit_margin($_POST['profit_margin']); 
$p->setPromotional_price($_POST['promotional_price']); 
$p->setLength($_POST['length']); 
$p->setWidth($_POST['width']); 
$p->setHeigth($_POST['heigth']); 
$p->setImg_relative_url($_POST['img_relative_url']); 
$p->setStatus($_POST['status']); 
$p->setBrands_brand_id($_POST['brands_brand_id']);
$p->setDepartaments_departament_id($_POST['departaments_departament_id']);

$arrayOptions =  array();
$options = new ProductOpitons();
$options->setQtd($_POST['product_stock_quantity']);
$options->setSize($_POST['idsize']);
$options->setColor($_POST['idcolor']);

$options1 = new ProductOpitons();


$options1->setQtd(15);
$options1->setSize(3);
$options1->setColor(3);


$arrayOptions[] = $options;

$arrayOptions[] = $options1;


$dao = new DaoProducts;

$dao->insertProduct($p, $arrayOptions);


    
    
    
    
// Caso contrário mostra o  formulário para inserir o produto    
}else{ ?>


<form action="/api/produtos/inserirproduto" method="post">
    
    
    
            <label>Nome</label>
            <br>
            <input type="text" name="nome" value="">
            <br><br>
            <label>Modelo</label>
            <br>
            <input type="text" name="model" value="">
            <br><br>
            <label>Codigo</label>
            <br>
            <input type="text" name="code" value="">
            <br><br>
            <label>Especificação</label>
            <br>
            <input type="text" name="specification" value="Espec">
            <br><br>
            
            <label>Preço de venda</label>
            <br>
            <input type="text" name="purchase_price" value="50">
            <br><br>
            <label>Margem de lucro</label>
            <br>
            <input type="text" name="profit_margin" value="10">
            <br><br>
            <label>Preço promocional</label>
            <br>
            <input type="text" name="promotional_price" value="0">
            <br><br>
            
            <label>Comprimento</label>
            <br>
            <input type="text" name="length" value="50">
            <br><br>
            <label>Largura</label>
            <br>
            <input type="text" name="width" value="50">
            <br><br>
            <label>Altura</label>
            <br>
            <input type="text" name="heigth" value="50">
            <br><br>
            
            <label>Status</label>
            
            <select name="status">
                  <option value="1">Ativo</option>
                  <option value="0">Desativado</option>
            </select>
            <br><br>
            <label>Quantidade em estoque</label>
            <br>
            <input type="text" name="product_stock_quantity" value="">
            <br><br>
            <label>Id da marca</label>
            <br>
            <input type="text" name="brands_brand_id" value="1">
            <br><br>
            
            <label> Id do departamento</label>
            <br>
            <input type="text" name="departaments_departament_id" value="1">
            <br><br>
            <label>Id da cor</label>
            <br>
<div id="options">            
            <?php
            /*

    $path = $_SERVER['DOCUMENT_ROOT'];
                require_once $path . '/Constants.php';
                require_once ROOT_DIR . '/Dao/DaoProducts.php';
                require_once ROOT_DIR . '/Dao/MysqlConn.php';
                require_once ROOT_DIR . '/Model/Product.php';

                $conn = new MysqlConn();

                $conn->Conecta();
            $sql = "SELECT * FROM products_color;";
            $sql2 = "SELECT * FROM products_size;";
           
                if ($result = mysqli_query($conn->getLink(), $sql)) {

                    if ($result->num_rows > 0) {
                        // output data of each row
                        
                        //echo "<div>";
                        
                        while ($row = $result->fetch_assoc()) {
                        echo "<br>";
                            echo "<input type='checkbox' name=" . $row["product_color"] . " value=" . $row["product_id_color"] . ">" . $row["product_color"] ;
                $result2 = mysqli_query($conn->getLink(), $sql2);

                    
                        // output data of each row
                           echo '<select name ="size">';
                            while ($row2 = $result2->fetch_assoc()) {
                                
                                    echo '<option value='.$row2['product_id_size'].' >'.$row2['product_size'].'</option>';
                                    
                                    }
                                
                                    echo '</select>';
                                    echo '  <label>Quantidade em estoque</label> 
                                            <input type="text" name="product_stock_quantity" value="">
                                            <br>';
                                    
                            header('Content-Type: text/html'); // declara o json para a extensão do chrome funcionar. 
                            
                        }
                        //echo "</div>";
                            header('Content-Type: text/html'); // declara o json para a extensão do chrome funcionar. 
                    } else {
                        echo "0 results";
                    }
                }else{
                    echo "erro";
                }
          */  
            
            ?>
</div>
            <input type="text" name="idcolor" value="1">
            <br><br>
            <label>Id do tamanho </label>
            <br>
            <input type="text" name="idsize" value="1">
            <br><br>
            
            <label>URL da imagem</label>
            <br>
            <input type="text" name="img_relative_url" value="urls teste">
            <br><br>
            
            <input type="submit" value="Submit">



        </form> 


<?php

}
?>
