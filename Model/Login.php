<?php

$path = $_SERVER['DOCUMENT_ROOT'];

require_once $path . '/Constants.php';

require_once ROOT_DIR . '/Dao/MysqlConn.php';
require_once ROOT_DIR . '/Model/Client.php';
require_once ROOT_DIR . '/Services/Cart.php';

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

    
    //Método que recebe os dados do formulário de login para verificar se o usuário existe no
    //banco de dados, caso exista será criado uma sessão para este.
    public function createSession() {
        //Abaixo verifica se os campos passados são nulos
        if ($this->username == NULL || $this->password == NULL) {
            return false;
        } else if ($this->password == NULL && $this->username == NULL) {
            return false;
        } else {
            //Se os campos do formulário for preenhido iniciamos o processo de busca
            $conn = new MysqlConn();
            $conn->Conecta();

            $query = "SELECT * FROM client WHERE client_password = ? AND client_user_name = ?;";

            $stmt = mysqli_prepare($conn->getLink(), $query);
            $stmt->bind_param("ss", password_hash($this->password, PASSWORD_DEFAULT), $this->username);

            if ($stmt->execute() == false) {
                //echo var_dump(mysqli_er($conn->getLink()));
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }



                $_SESSION['logado'] = array();
               // echo var_dump($_SESSION['logado']);
                echo "<br>";
                $_SESSION['logado']['usuario'] = $this->username;
                //echo var_dump($_SESSION['logado']);

                if (!isset($_SESSION['sacola'])) { //se a sacola não existe, cria ela
                    if (parent::createBag()) {
//                        echo "<br>";
//                        echo "parent";
//                        echo "<pre>";
                        //var_dump($_SESSION);
                        echo "</pre>";


                        // método que cria a sacola
                        //coloca a sacola dentro de carrinho, pois o usuário está logado
                        $_SESSION['logado']['carrinho'] = & $_SESSION['sacola'];

                        echo "<pre>";
                        //  var_dump($_SESSION);
                        echo "</pre>";

                        return true;
                    }
                } else {


                    //Se a sacola já é existente, o carrinho aponta para a sacola
                    session_start();

                    //s  $_SESSION['sacola'] = array();
                    $_SESSION['logado']['carrinho'] = $_SESSION['sacola'];

                    echo "<pre>";
                    var_dump($_SESSION);
                    echo "</pre>";

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
