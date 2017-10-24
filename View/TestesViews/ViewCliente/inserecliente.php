<?php
//ini_set('display_errors', 0);
/*
 * Este arquivo juntei o php e html para facilitar a motagem do teste. 
 * Esse poderá ser usado como interface para cadastro de produtos
 */

//Verifica se o post vindo do name "code", no html, está vazio, 
//se não recebe os parâmetros e tenta inserir no banco

echo $_POST['client_name'];
if ($_POST['client_name']) {

    $path = $_SERVER['DOCUMENT_ROOT'];
    require_once $path . '/Constants.php';
    require_once ROOT_DIR . '/Dao/DaoClient.php';
    require_once ROOT_DIR . '/Dao/MysqlConn.php';
    require_once ROOT_DIR . '/Model/Client.php';


    $c = new Client();
    $c->setId(null);
    $c->setName($_POST['client_name']);
    $c->setEmail($_POST['client_email']);
    $c->setCpf($_POST['client_cpf']);
    $c->setSex($_POST['client_sex']);
    $c->setPassword($_POST['client_password']);
    $c->setBirthday($_POST['client_birthday']);
    $c->setTel($_POST['client_tel']);
    $c->setCel($_POST['client_cel']);
    $c->setDirectmail($_POST['client_direct_mail']);
    $c->setAdressType($_POST['client_adress_type']);
    $c->setAdressCep($_POST['client_adress_cep']);
    $c->setAdressLogradouro($_POST['client_adress_logradouro']);
    $c->setAdressNumber($_POST['client_adress_number']);
    $c->setAdressComplement($_POST['client_adress_complements']);
    $c->setAdressDistrict($_POST['client_adress_district']);
    $c->setAdressCity($_POST['client_adress_city']);
    $c->setAdressState($_POST['client_adress_state']);
    $c->setStatus($_POST['client_status']);
    $c->setName($_POST['client_user_name']);
    
    
    
    
    
$dao = new DaoClient();
$dao->insertClient($c);

// Caso contrário mostra o  formulário para inserir o produto    
} else {
    ?>

    <form action="inserecliente.php" method="POST">

          <label>client nome</label>
        <br>
        <input id="client_nome" type="text" name="client_name" value="TESTE">
        <br><br>

        <label>client email</label>
        <br>
        <input id="client_email" type="text" name="client_email" value="TSETE@TESTE">
        <br><br>

        <label>client cpf</label>
        <br>
        <input id="client_cpf" type="text" name="client_cpf" value="123465">
        <br><br>

        <label>client sex</label>
        <br>
        <input id="client_sex" type="text" name="client_sex" value="1">
        <br><br>

        <label>client password</label>
        <br>
        <input id="client_password" type="text" name="client_password" value="123456">
        <br><br>

        <label>client birthday</label>
        <br>
        <input id="client_birthday" type="text" name="client_birthday" value="2017-10-11 00:00:00">
        <br><br>

        <label>client tel</label>
        <br>
        <input id="client_tel" type="text" name="client_tel" value="123456">
        <br><br>

        <label>client cel</label>
        <br>
        <input id="client_cel" type="text" name="client_cel" value="12345678">
        <br><br>

        <label>client direct mail</label>
        <br>
        <input id="client_direct_mail" type="text" name="client_direct_mail" value="0">
        <br><br>

        <label>client adress type</label>
        <br>
        <input id="client_adress_type" type="text" name="client_adress_type" value="teste">
        <br><br>

        <label>client adress cep</label>
        <br>
        <input id="client_adress_cep" type="text" name="client_adress_cep" value="12345687">
        <br><br>

        <label>client adress logradouro</label>
        <br>
        <input id="client_adress_logradouro" type="text" name="client_adress_logradouro" value="teste">
        <br><br>

        <label>client adress number</label>
        <br>
        <input id="client_adress_number" type="text" name="client_adress_number" value="123456">
        <br><br>

        <label>client adress complements</label>
        <br>
        <input id="client_adress_complements" type="text" name="client_adress_complements" value="teste">
        <br><br>

        <label>client adress district</label>
        <br>
        <input id="client_adress_district" type="text" name="client_adress_district" value="teste">
        <br><br>

        <label>client adress city</label>
        <br>
        <input id="client_adress_city" type="text" name="client_adress_city" value="teste">
        <br><br>

        <label>client adress state</label>
        <br>
        <input id="client_adress_state" type="text" name="client_adress_state" value="teste">
        <br><br>

        <label>client status</label>
        <br>
        <input id="client_status" type="text" name="client_status" value="1">
        <br><br>

       

        <input type="submit" value="Submit">

    </form> 

    <?php
}
?>