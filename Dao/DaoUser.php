<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoUser
 *
 * @author willianvieira
 */

    $path = $_SERVER['DOCUMENT_ROOT'];
    require_once $path . '/Constants.php';
    require_once ROOT_DIR.'/Dao/MysqlConn.php';
    require_once ROOT_DIR.'/Model/User.php';


class DaoUser {
    
    
    //Insere cliente
    public function insertUser(User $user) {
        //Instância o objeto conexão
        $conn = new MysqlConn();
        //Conecta
        $conn->Conecta(); //cria conexão

        try {

            // preparando o stmt
            //date('Y-m-d',strtotime($_POST['date_field']))
            $id = null;
            $stmt = mysqli_prepare($conn->getLink(), "
                INSERT INTO users (
                 user_id,
                 users_roles_id,
                 user_name,
                 user_password) 
                VALUES ( 
                 ?, 
                 ?, 
                 ?,
                 ?)
                ");


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
            $idRole=1;
              echo var_dump(mysqli_error($conn->getLink())); 
            $stmt->bind_param("iiss",
                    $id,
                    $idRole,
                    $user->getUserName(),
                    $user->getUserPassword()
                    );
            echo var_dump(mysqli_error($conn->getLink())); 
            
            //Executa o comando de inserção
            $stmt->execute();
                        echo var_dump(mysqli_error($conn->getLink()));  

            $stmt->close();
            $conn->Desconecta();
        
           } catch (Exception $ex) {
            
               $conn->Desconecta();
        
               
           }
    }
     
    public function findUser($uname, $upassword){




                  //Instância o objeto conexão
        $conn = new MysqlConn();
        //Conecta
        $conn->Conecta(); //cria conexão
        
   //$sql = "SELECT * FROM `users` WHERE `user_name` = \"".$uname."\" AND `user_password` = \"".$hash."\"";
   $sql = "SELECT * FROM "
           . "`users` "
           . "INNER JOIN users_roles "
           . "ON users_roles.user_role_id = users.users_roles_id "
           . "WHERE `user_name` = \"".$uname."\"";
   
    
           
           
        if ($result = mysqli_query($conn->getLink(), $sql)) {

            if (mysqli_num_rows($result)) {
                
                $arraySqlresult = (mysqli_fetch_array($result));
                
                if (password_verify($upassword, $arraySqlresult['user_password'])) {
                       if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
                    $_SESSION['perfil'] = $arraySqlresult['name_role'];
                    return true;
                } else {
                    return false;
                }
            } else {
                echo "Usuário não encontrado";
                return false;
            }
        } else {
            var_dump(mysqli_error($conn->getLink()));
        }
    }
    
}
