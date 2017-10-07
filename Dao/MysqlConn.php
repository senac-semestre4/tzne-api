<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of MysqlConn
 *
 * @author Willian Vieira
 */
class MysqlConn {

    private $usuario = "PI4";
    private $senha = "123456";
    private $sid = "banco.kwcraft.com.br";
    private $banco = "PI4";
    private $link;


    function Conecta() {

        $this->link = mysqli_connect($this->sid, $this->usuario, $this->senha);
        $this->link->set_charset("utf8");
        if (!$this->link) {
            //printf("Connect failed: %s\n", mysqli_connect_error());
            die("Problema com os dados de conexão, verifique usuário e senha");
        } elseif (!mysqli_select_db($this->link, $this->banco)) {

            die("Problema com o banco de dados selecinado");
        } else {
            // echo "Conectou";
            return $this->link;
        }
    }
/*
    function query($link, $sql) {

        return mysqli_query($link, $sql);
    }
*/
    function prepare($link, $sql) {

        return mysqli_prepare($link, $sql);
        
    }

    function Desconecta() {

        if (mysqli_close($this->link)) {
           //echo 'Desconectou';
        } else {
           // echo 'erro';
        }
    }

    function getBanco() {
        return $this->banco;
    }

    function getLink() {
        return $this->link;
    }

}
