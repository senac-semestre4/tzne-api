<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Willian Vieira
 */ 
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once ROOT_DIR.'/Dao/MysqlConn.php';
require_once ROOT_DIR.'/Model/Client.php';





class DaoClient {
    
    
    //Insere cliente
    public function insertClient(Client $client) {
        //Instância o objeto conexão
        $conn = new MysqlConn();
        //Conecta
        $conn->Conecta(); //cria conexão
        echo "ola ". $client->getName();
        try {

            // preparando o stmt
            //date('Y-m-d',strtotime($_POST['date_field']))
            $id = null;
            $stmt = mysqli_prepare($conn->getLink(), "
                INSERT INTO client (
                 client_id,
                 client_name,
                 client_email,
                 client_cpf,
                 client_sex,
                 client_password,
                 client_birthday,
                 client_tel,
                 client_cel,
                 client_direct_mail,
                 client_adress_type,
                 client_adress_cep,
                 client_adress_logradouro,
                 client_adress_number,
                 client_adress_complements,
                 client_adress_district,
                 client_adress_city,
                 client_adress_state,
                 client_status) 
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
            $id = null;
            
            $stmt->bind_param("issssssssisssissssi",
                    $id,
                    $client->getName(),
                    $client->getEmail(),
                    $client->getCpf(),
                    $client->getSex(),
                    $client->getPassword(),
                    $client->getBirthday(),
                    $client->getTel(),
                    $client->getCel(),
                    $client->getDirectmail(),
                    $client->getAdressType(),
                    $client->getAdressCep(),
                    $client->getAdressLogradouro(),
                    $client->getAdressNumber(),
                    $client->getAdressComplement(),
                    $client->getAdressDistrict(),
                    $client->getAdressCity(),
                    $client->getAdressState(),
                    $client->getStatus());
            
            //Executa o comando de inserção
            $stmt->execute();
                        echo var_dump(mysqli_error($conn->getLink()));  

            $stmt->close();
            $conn->Desconecta();
        
           } catch (Exception $ex) {
            
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
        
          $query ="SELECT * FROM client   WHERE client_id =" . $id;
        if($result = mysqli_query($conn->getLink(), $query)) {
           
                    
          $json= mysqli_fetch_assoc($result);
          

            mysqli_free_result($result);
            
            
               echo json_encode($json)  ;
           
          
            $conn->Desconecta();

            return true;
        }else{
            
            $conn->Desconecta();
            return false;
        }
        
    }
    
        
     public function listByName($name){
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
        
          $query ="SELECT * FROM client  WHERE client_name LIKE \"" . $name. "\"";
          
        if($result = mysqli_query($conn->getLink(), $query)) {
           
                    
          $json= mysqli_fetch_assoc($result);
          

            mysqli_free_result($result);
            
            
               echo json_encode($json)  ;
           
          
            $conn->Desconecta();

            return true;
        }else{
            
            $conn->Desconecta();
            return false;
        }
        
    }
    
        
    public function listAllClients() {
        $conn = new MysqlConn();
        $conn->Conecta();

        /*$json 
         * Array que terá o resultado de > "Select * from clients"
         */
        
        $json = array();
        
        $result = mysqli_query($conn->getLink(), "Select * from client");

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

    public function removeByID($id) {
        $conn = new MysqlConn();
        $conn->Conecta();
        //Executa a query recebendo o parametro do produto que será deletado
        $query = "DELETE FROM client WHERE client_id =" . $id . " LIMIT 1";
        if (mysqli_query($conn->getLink(), $query)) {
            // echo var_dump(mysqli_error($conn->getLink()));  
            $conn->Desconecta();
            return true;
        } else {
           // echo var_dump(mysqli_error($conn->getLink()));

            $conn->Desconecta();
            return false;
        }
    }

    /*
     * Atualiza produto no banco
     * Recebe  um produto do Front-end para ser atualizado no banco.
     */

    public function findClient($email, $password){
                  //Instância o objeto conexão
        $conn = new MysqlConn();
        //Conecta
        $conn->Conecta(); //cria conexão
        
   //$sql = "SELECT * FROM `users` WHERE `user_name` = \"".$uname."\" AND `user_password` = \"".$hash."\"";
   $sql = "SELECT * FROM "
           . "`client` "
           . "WHERE `client_email` = \"".$email."\"";
   
    
           
           
        if ($result = mysqli_query($conn->getLink(), $sql)) {
            if (mysqli_num_rows($result)) {
                
                $arraySqlresult = (mysqli_fetch_array($result));
                
                if (password_verify($password, $arraySqlresult['client_password'])) {
                      	
                      	//Verifica se tem sessão
                       if (!isset($_SESSION)) {
                            session_start();
       				} else {
           					 //echo"ja tem sessao";
       					 }

                    $_SESSION['cliente'] = $arraySqlresult['client_name'];
                              return true;

                } else {
                    return false;
                }
                
            } else {
                echo "Cliente não encontrado";
                return false;
            }
        } else {
            var_dump(mysqli_error($conn->getLink()));
        }
    }


public function updateClient(Client $client) {

        $conn = new MysqlConn();

        $conn->Conecta(); //cria conexão

        try {

            // preparando o stmt
            $stmt = myslqi_prepare($conn->getLink(), "
                    UPDATE Client SET
                    client_nome = '?', 
                    client_email = '?', 
                    client_cpf = '?', 
                    client_sex = '?', 
                    client_password = '?', 
                    client_birthday = '?', 
                    client_tel = '?', 
                    client_cel = '?', 
                    client_direct_mail = '?', 
                    client_adress_type = '?', 
                    client_adress_cep = '?', 
                    client_adress_logradouro = '?', 
                    client_adress_number = '?', 
                    client_adress_complements = '?', 
                    client_adress_district = '?', 
                    client_adress_city = '?', 
                    client_adress_state = '?' 
                    WHERE Client.client_id = '?';");


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
            $stmt->bind_param("sssss",$client->getBirthday(),"ssbsssissssi",
                    
                    $client->getName(),
                    $client->getEmail(),
                    $client->getCpf(),
                    $client->getSex(),
                    $client->getPassword(),
                    $client->getBirthday(),
                    $client->getTel(),
                    $client->getCel(),
                    $client->getDirectmail(),
                    $client->getAdressType(),
                    $client->getAdressCep(),
                    $client->getAdressLogradouro(),
                    $client->getAdressNumber(),
                    $client->getAdressComplement(),
                    $client->getAdressDistrict(),
                    $client->getAdressCity(),
                    $client->getAdressState(),
                    $client->getId());
            
            $stmt->execute();
            
            $conn->Desconecta();

            try {
                $stmt->close();
                $conn->Desconecta();
            } catch (Exception $ex) {
                $stmt->close();
                $conn->Desconecta();
            }
        } catch (Exception $ex) {
            $conn->Desconecta();
        }
    }    
    
   
    
    
    
}
