<?php
header('Content-Type:  text/html; application/json'); // declara o json para a extensão do chrome funcionar. 

/**
 * Description of Cart
 *
 * @author Willian Vieira
 */
$path = $_SERVER['DOCUMENT_ROOT'];
require_once ROOT_DIR . '/Constants.php';
require_once ROOT_DIR . '/Model/Product.php';

class Cart extends Product {

    private function createBag() {

        if (!isset($_SESSION['sacola'])) {
            echo "sacola criada";
            echo "<br>";
            $_SESSION['sacola'] = array();

            return true;
        }
        return false;
    }

    function addProduct(Product $p) {
        
        
           $this->createBag();
  
            $tamanhoSacola = sizeof($_SESSION['sacola']);
            echo"<br>";
            echo"tam ve ".$tamanhoSacola ;
            echo"<br>";
        if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }


        /*
        $p->setId($id);
        $p->setQtd($qtd);
        $p->setTshirtColor($cor);
        $p->setTshirtSize($tam);
*/

        if (!array_key_exists("sacola", $_SESSION)) {

            echo "criando sacola";
            $this->createCart();
  
            }else{

        if (current($_SESSION['sacola']) == null) {


            echo"<pre>";
            echo "Primeiro produto adicionado";
            echo"<pre>";

            array_push($_SESSION['sacola'], $p);

            return true;
        } else {
                
            $indice;
            
            for ($i= 0; $i < $tamanhoSacola; $i++) {
                    
                    if($_SESSION['sacola'][$i]->getId()== $p->getId()){
                        $indice = $i;
                        
                        //break;
                    }else{
                         $indice =-1;
                         }
                      
            }
            
            if(!isset($indice)){
                echo "Sem valor";
            }else{
                
                if($indice == -1){
                                echo "<br>";  
                                echo "Mais um produto adicionado";  
                                echo "<br>";                      
                    array_push($_SESSION['sacola'], $p);                    
                }else{
                
                if($_SESSION['sacola'][$indice]->getTshirtColor() == $p->getTshirtColor()
                && $_SESSION['sacola'][$indice]->getTshirtSize() == $p->getTshirtSize()){
                    $qtd =     $_SESSION['sacola'][$indice]->getQtd();
                    $qtd++;
                                echo "<br>";  
                                echo "quantidade alterada";  
                                echo "<br>";  
                    $_SESSION['sacola'][$indice]->setQtd($p->getQtd());
                               
                }else if($_SESSION['sacola'][$indice]->getTshirtColor() != $p->getTshirtColor()
                      && $_SESSION['sacola'][$indice]->getTshirtSize() == $p->getTshirtSize()){
                                echo "<br>";  
                                echo "tam igual  cor diferente";  
                                echo "<br>";                         
                                    array_push($_SESSION['sacola'], $p);

                }else if($_SESSION['sacola'][$indice]->getTshirtColor() == $p->getTshirtColor()
                      && $_SESSION['sacola'][$indice]->getTshirtSize() != $p->getTshirtSize()){
                                echo "<br>";  
                                echo "tam diferente   cor igual";
                                echo "<br>";                   
                    array_push($_SESSION['sacola'], $p);
                            
                }else if($_SESSION['sacola'][$indice]->getTshirtColor() != $p->getTshirtColor()
                      && $_SESSION['sacola'][$indice]->getTshirtSize() != $p->getTshirtSize()){
                                echo "<br>";  
                                echo "tam diferente cor diferente";  
                                echo "<br>";                   
                    array_push($_SESSION['sacola'], $p);

                    }
                  }
                
                }
            }

        
    }
 }        
  

    function listBagItems() {
        if ($_SESSION['sacola'] == null) {
            return false;
        } else {
            for ($i = 0; $i < sizeof($_SESSION['sacola']); $i++) {

                $json [] = $_SESSION['sacola'][$i]->serialize();
            }
            echo json_encode($json, JSON_PRETTY_PRINT);
        }
    }

    function listCartItems() {
        echo "<pre>";
        //echo var_dump($_SESSION);
        echo "</pre>";
        // Verificar se a sessão de usuário e carrinho existem
        //caso não exista imprime somente a sacola.
        if (!isset($_SESSION['logado']['carrinho'])) {

            $this->listBagItems();
            return true;
        } else {
            //Imprime a sacola que está dentro do carrinho, essa é um array.
            for ($i = 0; $i < sizeof($_SESSION['logado']['carrinho']); $i++) {
                echo json_encode($_SESSION['logado']['carrinho'][$i]->serialize(), JSON_PRETTY_PRINT);
            }

            return true;
        }
    }
    
    private function findProduct(Product $p){

            for($i =0; $i < sizeof($_SESSION['sacola']); $i++){
                    $paux = new Product();
                    $paux = $_SESSION['sacola'][$i];

                    if($paux == $p){
                        echo "está na pos ".$i. " da sacola";
                            echo json_encode($paux->serialize(), JSON_PRETTY_PRINT);
                            echo "fim find";
                        break;
                    }

            }
    }

}

?>
