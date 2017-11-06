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
require_once ROOT_DIR . '/Helpers/ToJson.php';

class Cart extends Product {

    
    /*
     * Funcção responsavel por verificar se existe
     * a session chamada "sacola", se não ela cria.
     * 
     * A sacola é o array de produtos do cliente
     */
    public function createBag() {
   if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
        if (!isset($_SESSION['sacola'])) {
          //  echo "sacola criada";
            //echo "<br>";
            $_SESSION['sacola'] = array();

            return true;
        }
        return false;
    }

    /*
     * Funcão "addProduct", é responsavel por adicionar produtos na session
     * "sacola"
     */
    function addProduct(Product $p) {
            
        //Verifica se existe sessão, se não cria
            if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }


        //Cria a sacola se não existir (ver lógica no "createBag)
        $this->createBag();
  
            //Armazena o length, do vetor sacola
            $tamanhoSacola = sizeof($_SESSION['sacola']); 
//            echo"<br>";
//            echo"tam ve ".$tamanhoSacola ;
//            echo"<br>";
//            
    


            //Verifica se existe a chave "sacola" na sessão para seguir 
            // adicionando os produtos
        if (!array_key_exists("sacola", $_SESSION)) {
            // se não tiver cria a sacola
            //echo "criando sacola";
            $this->createCart();
  
            }else{
          /*
           * Se já existe, verifica se é nula, pois sendo nula podemos
           * adicionar o primeiro produto na posição 0 da sacola
           */
        if (current($_SESSION['sacola']) == null) {

            
//            echo"<pre>";
//            echo "Primeiro produto adicionado";
//            echo"<pre>";
              //Se for nula, adiciona o primeiro produto
            array_push($_SESSION['sacola'], $p);

            return true;
        } else {
            /*
             * Se a sacola existe e tem produtos, temos que verificar 
             * os produtos da lista para não adicionar itens repeditos
             * 
             * O array "indice" irá armazenar as posicões da sacola que possuem
             * o mesmo código de produto(não é o id do banco)
             */
            $indice = array();
            
            /*
             * Verifico isso percorrendo a "sacola", comparando o 
             * código de produto contidos na sacola, com o código de produto 
             * passado como parametro
             */
            for ($i= 0; $i < $tamanhoSacola; $i++) {
                    
                    if($_SESSION['sacola'][$i]->getId()== $p->getId()){
                    /*Armazena no array "indice", cada indice da sacola que 
                     * possui  o mesmo codigo de produto 
                     */
                         array_push($indice, $i);
                    }
                    
            }

            
            
            if (!isset($indice)) {
                //  echo " Indice sem valor";
                } else {
                        
                    /*
                     * Se o array não for vazio, chamo a função 
                     * responsável por comparar os produtos de mesmo código
                     * "equalsItemBag"
                     * 
                     * Se o retordo de equalsItemBag é falso, significa que
                     * podemos adicionar o produto na sacola, pois não há 
                     * produtos com a mesma característica
                     */
                    if ($this->equalsItemBag($p, $indice) == false) {
                        array_push($_SESSION['sacola'], $p);
                    }else{
                        //Se contém o produto, informa que já foi adicionado
//                  
//                              echo "produto já adicioado";
//                        echo "<br>";
                    }

                }
            }

        
    }
 }        
  
/*
 * A função listBagItems, lista todos os produtos da sacola
 * 
 */
 public function listBagItems() {
        
        if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
//Verifica se a sacola é nula
        if ($_SESSION['sacola'] == null) {
            return false;
        } else {
            //Se não for nula, imprime todos os produtos no formato json
            for ($i = 0; $i < sizeof($_SESSION['sacola']); $i++) {
                  $json [] = $_SESSION['sacola'][$i]->serializeProduct();
                  $json [] = $_SESSION['sacola'][$i]->serializeOptions();
                //$json [] = $_SESSION['sacola'][$i]->getOptions()[0];
                //$json [] = $_SESSION['sacola'][$i]->serializeOptions();
            }
            //echo json_encode($json, JSON_PRETTY_PRINT);
            //echo var_dump($json);
            echo json_encode(new ToJson($json), JSON_PRETTY_PRINT);
  
        }
    }

    function listCartItems() {
       
           if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
// echo "<pre>";
        //echo var_dump($_SESSION);
        echo "</pre>";
        // Verificar se a sessão de usuário e carrinho existem
        //caso não exista imprime somente a sacola.
        if (!isset($_SESSION['logado']['carrinho'])) {

            $this->listBagItems();
            return true;
        } else {
            //Imprime a sacola que está dentro do carrinho, essa é um array.
            
            $json = array(); //Array que recebe a lista da sacola
            for ($i = 0; $i < sizeof($_SESSION['logado']['carrinho']); $i++) {
                //percorrendo o carrinho, armazenando no array
                $json[] = $_SESSION['logado']['carrinho'][$i]->serialize();
                
            }
            //Modifica o header da aplicação para json
            header('Content-Type: application/json');  
            //imprime o Json
            echo json_encode($json, JSON_PRETTY_PRINT);
            return true;
        }
    }
    
    /*
     * A função findProduct, recebe o produto e o encontra na sessão "sacola"
     * e o imprime em formato json
     */
    
     function findProduct(Product $p){
            if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
            for($i =0; $i < sizeof($_SESSION['sacola']); $i++){
                    $paux = new Product();
                    $paux = $_SESSION['sacola'][$i];

                    if($paux == $p){
                        echo "está na pos ".$i. " da sacola";
                            echo json_encode($paux->serialize(), JSON_PRETTY_PRINT);
                            echo "fim find";
                        return $i;
                    }

            }
    }
    /*
     * A função removeItemBag, remove um item, passado por parâmetro, da sessão "sacola" 
     */
    public function removeItemBag(Product $p) {
           if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
        try {
            /*
             * Encotra a posição chamando a função findProduct
             * e armazena na variavel "pos".
             */
            $pos = $this->findProduct($p);
            
            /*
             * Crio um novo array, para copiar outro sem os valores nulos, 
             * pois após removermos da sacola ficará um "buraco" nulo.
             */
            $sacola =   array();
            
            //Deletamos a posição, definindo ela como nula
            $_SESSION['sacola'][$pos] = null;
            
            //Copiamos a sacola para o array local "$sacola", exceto as posições nulas
            for($i = 0; $i < sizeof($_SESSION['sacola']); $i++){
                    
                    if($_SESSION['sacola'][$i] != null){
                        array_push($sacola, $_SESSION['sacola'][$i]);
                    }
                
            }
            /*Ao final da operação, falamos que a sessão "sacola" recebe o array local 
             * "$sacola", já sem os valores nulos.
             */
            $_SESSION['sacola'] = $sacola;
            //Libero o array local da memória.
            unset($sacola);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     * A função equalsItemBag, é responsavel por receber um objeto
     * do tipo produto, e um array que contenha os indices de uma sessão "sacola",
     * para poder comparar se o produto já foi adicionado à sacola
     */
    public function equalsItemBag(Product $p, $indice) {
               if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
        /*
         * Percorre até o tamanho do array indice, verificando se a sacola, na 
         * posição do valor armazenado em indice[i], possui o mesmo código 
         * do produto passado como parâmetro, se sim, verifica se as cores e tamanhos
         * são iguais, se forem iguais, o retorno é true, se não tiver produto igual, o retorno
         * é false.
         */
        for ($i = 0; $i < sizeof($indice); $i++) {
            if ($_SESSION['sacola'][$indice[$i]]->getId() == $p->getId()) {
                if ($_SESSION['sacola'][$indice[$i]]->getTshirtColor() == $p->getTshirtColor() && $_SESSION['sacola'][$indice[$i]]->getTshirtSize() == $p->getTshirtSize()) {
                    return true;
                }
            }
        }
        return false;
    }

}

?>
