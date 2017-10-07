<?php

$path = $_SERVER['DOCUMENT_ROOT'];

require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/Client.php';
require_once ROOT_DIR.'/Services/Cart.php';
 
/**
 * Description of Login
 *
 * @author willian.mvieira
 */
class Login extends Cart {

    private $username;
    private $password;
    

    function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }


    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }


    public function createSession() {
        if ($this->username == NULL || $this->password== NULL) {
            return false;
        } else if ($this->password == NULL && $this->username== NULL) {
            return false;
        } else {

            $conn = new MysqlConn();
            $conn->Conecta();

            $query = "SELECT * FROM client WHERE client_password = ? AND client_user_name = ?;";

            $stmt = mysqli_prepare($conn->getLink(), $query);
            $stmt->bind_param("ss",  password_hash($this->password, PASSWORD_DEFAULT), $this->username);
            
            if ($stmt->execute()== false) {
                //echo var_dump(mysqli_er($conn->getLink()));
            } else {
                session_start();
                
                $_SESSION['logado'] = array();
                $_SESSION['logado']['usuario'] = $this->username;
                
                
                if($_SESSION['sacola'] == null){ //se a sacola estiver vazia, cria ela
                    parent::createCart(); // método que cria a sacola
                    $_SESSION['logado']['carrinho'] = array();
                     //coloca a sacola dentro de carrinho, pois o usuário está logado
                    $_SESSION['logado']['carrinho']= $_SESSION['sacola'];
                    return true;
                } else{
                    //Se a sacola já é existente, o carrinho aponta para a sacola
                    $_SESSION['logado']['carrinho'] = array();
                    $_SESSION['logado']['carrinho']= $_SESSION['sacola'];
                    return true;
                    
                }
                
                
            }
        }
    }

    //Função que será usada quando o cliente clicar em "SAIR"
    public function removeSession() {
        if (!session_start()) {
            session_start();
            session_destroy();
        } else {
            echo "Sessão não criada, logue primeiro";
        }
    }
    
    
    

}
