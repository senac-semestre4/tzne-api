<?php
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DoaProducts
 *
 * @author Willian Vieira
 */
require_once 'C:\xampp\htdocs\EcommercePI4\validacao.php';
require_once 'C:\xampp\htdocs\EcommercePI4\Dao\MysqlConn.php';
require_once '../Model/Produtct.php  ';

class DaoTesteProduct {

    public function InsertProduct(Produtct $product) {
        //instancia conexão
        $conn = new MysqlConn();
        //Atribui o link do mysql a variavel $link, para podermos usar seus métodos
        $link = $conn->Conecta();            
        //Query teste
        $sql ="INSERT INTO produto(id, tipo, nome) VALUES (?,?,?);";

        try {


// preparando o stmt
            
            if($stmt = mysqli_prepare($link, $sql)){
                echo 'stmt criado';
            }else{
                echo 'stmt não criado';
                echo mysqli_errno($link);
            }
            

           
            /*
             * bind_param 
             * Caractere	Descrição
              i	corresponde a uma variável de tipo inteiro
              d	corresponde a uma variável de tipo double
              s	corresponde a uma variável de tipo string
              b	corresponde a uma variável que contém dados para um blob e enviará em pacotes
             * 
             */
            $id = null;
            $tipo = $product->getName();
            $nome = $product->getName();
            
            $stmt->bind_param("iss", $id,$product->getName(),$product->getName());

            $stmt->execute();

            echo "Gravado no banco";
            try {
                $stmt->close();
                $link->close();
            } catch (Exception $ex) {
                $stmt->close();
                $link->close();
            }
        } catch (Exception $ex) {
            $link->close();
        }
    }

    
    
    
    public function updateProduct(Produtct $product) {
        //instancia conexão
        $conn = new MysqlConn();
        //Atribui o link do mysql a variavel $link, para podermos usar seus métodos
        $link = $conn->Conecta();            
        //Query teste
        $sql ="UPDATE  produto SET tipo = ?, nome = ? WHERE id = ?";

        try {


// preparando o stmt
            
            if($stmt = mysqli_prepare($link, $sql)){
                echo 'stmt criado';
            }else{
                echo 'stmt não criado';
                echo mysqli_errno($link);
            }
            

           
            /*
             * bind_param 
             * Caractere	Descrição
              i	corresponde a uma variável de tipo inteiro
              d	corresponde a uma variável de tipo double
              s	corresponde a uma variável de tipo string
              b	corresponde a uma variável que contém dados para um blob e enviará em pacotes
             * 
             */
            $id = 1;
            $tipo = $product->getName();
            $nome = $product->getName();
            
            $stmt->bind_param("ssi", 
                    $product->getName(),
                    $product->getName(),
                    $id);

            $stmt->execute();

            echo "Update realizado";
            try {
                $stmt->close();
                $link->close();
            } catch (Exception $ex) {
                $stmt->close();
                $link->close();
            }
        } catch (Exception $ex) {
            $link->close();
        }
    }
    
    
     public function listByID($id){
        $conn = new MysqlConn();
        $conn->Conecta();// cria o link
        
        $json;
        
        $query = "SELECT * FROM produto WHERE ID =" . $id;
        
        if ($result = mysqli_query($conn->getLink(), $query)) {

            $json= mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            $conn->Desconecta();
             echo json_encode($json);
            
             return $json;
            
        } else {
            $conn->Desconecta();
            
            return false;
        }
        
    }
    
    
    
    
    
}

?>