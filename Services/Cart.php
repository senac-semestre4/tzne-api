<?php

/**
 * Description of Cart
 *
 * @author Willian Vieira
 */
$path = $_SERVER['DOCUMENT_ROOT'];
require_once ROOT_DIR . '/Constants.php';
require_once ROOT_DIR . '/Model/Product.php';

class Cart extends Product {

    public function createCart() {



        if (!isset($_SESION['sacola'])) {
            $_SESION['sacola'] = array();
            return true;
        } else {
            return false;
        }
    }

    function addProduct($id, $qtd, $cor, $tam) {


        session_start();
        $p = new Product();
        $p->setId($id);
        $p->setQtd($qtd);
        $p->setTshirtColor($cor);
        $p->setTshirtSize($tam);






        for ($i = 0; $i <= sizeof($_SESSION['sacola']); $i++) {

            if ($_SESSION['sacola'] == null) {
                array_push($_SESSION['sacola'], $p);
                break;
            } else {
                //var_dump($_SESSION);

                //Se o id cor e tamanho são iguais
                if ($_SESSION['sacola'][$i]->getId() == $p->getId()) {
                    if ($_SESSION['sacola'][$i]->getTshirtColor() == $p->getTshirtColor()) {
                        if ($_SESSION['sacola'][$i]->getTshirtSize() == $p->getTshirtSize()) {
                
                            
                            $_SESSION['sacola'][$i]->setQtd($qtd);
                            break;
                        }
                    }
                } else {
                    array_push($_SESSION['sacola'], $p);
                    break;
                }
            }
        }
    }

}
