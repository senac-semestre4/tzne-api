<?php

require_once  'C:\xampp\htdocs\EcommercePI4\Dao\MysqlConn.php';
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 


/*
 * Testa  a Classe de conexão com o banco
 */

// instância a conexão
$con = new MysqlConn();
//executa a conexão
$con->Conecta();

//método que executa a query, pegando o link gerado pela conexão e a query
//********CRUD***********
$json = array();
//
////CREATE
mysqli_query($con->getLink(), "INSERT INTO `produto` (`id`, `tipo`, `nome`) VALUES (NULL, 'teste3', 'teste3');");
$json[] = "criado"; 
//READ
$result = mysqli_query($con->getLink(), "Select * from produto");
$json[] = "lido";


//UPDATE
mysqli_query($con->getLink(), "UPDATE `produto` SET `nome` = 'UPDATE TESTE' WHERE `produto`.`id` = 2");
$json[] = "atualizado";
//DELETE
mysqli_query($con->getLink(), "DELETE FROM `produto` WHERE `produto`.`id` = 2;");
$json[] = "deletado";
//
//
//
//$con->query($con->getLink(), "INSERT INTO `produto` (`id`, `tipo`, `nome`) VALUES (NULL, 'teste3', 'teste3');");
//"<pre>" -> usado para formatar  a saída
//echo "<pre>";
//var_dump, para ver o objeto
//var_dump($result);
//echo "</pre>";



while ($row = $result-> fetch_assoc()) {

    //$row[id] = campo id da tabela
    //$row[tipo] = campo tipo da tabela
    //$row[nome] = campo nome da tabela
    //   echo "id: " . $row["id"]. " - Tipo: " . $row["tipo"]. "Nome " . $row["nome"]. "<br>";
    $json[] = $row;
}

echo json_encode($json);

if ($con->Desconecta()) {

    //echo "Desconectou"; 
}
?>