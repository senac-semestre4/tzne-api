<?php

//require_once  '../validacao.php';


class Client {

    private $id;  
    private $name;
    private $email; // não altera
    private $cpf; // não altera
    private $sex;
    private $password;
    private $birthday; 
    private $tel;
    private $cel;
    private $directmail;
    private $adressCep;
    private $adressLogradouro;
    private $adressNumber;
    private $adressType;
    private $adressComplement;
    private $adressDistrict; // bairro
    private $adressCity;
    private $adressState;
    private $status;
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getSex() {
        return $this->sex;
    }

    function getPassword() {
        return $this->password;
    }

    function getBirthday() {
        return $this->birthday;
    }

    function getTel() {
        return $this->tel;
    }

    function getCel() {
        return $this->cel;
    }

    function getDirectmail() {
        return $this->directmail;
    }

    function getAdressCep() {
        return $this->adressCep;
    }

    function getAdressLogradouro() {
        return $this->adressLogradouro;
    }

    function getAdressNumber() {
        return $this->adressNumber;
    }

    function getAdressType() {
        return $this->adressType;
    }

    function getAdressComplement() {
        return $this->adressComplement;
    }

    function getAdressDistrict() {
        return $this->adressDistrict;
    }

    function getAdressCity() {
        return $this->adressCity;
    }

    function getAdressState() {
        return $this->adressState;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

   function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setSex($sex) {
        $this->sex = $sex;
    }

    function setPassword($password) {
        
        $this->password = password_hash($password, PASSWORD_DEFAULT) ;
    }

    function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setCel($cel) {
        $this->cel = $cel;
    }

    function setDirectmail($directmail) {
        $this->directmail = $directmail;
    }

    function setAdressCep($adressCep) {
        $this->adressCep = $adressCep;
    }

    function setAdressLogradouro($adressLogradouro) {
        $this->adressLogradouro = $adressLogradouro;
    }

    function setAdressNumber($adressNumber) {
        $this->adressNumber = $adressNumber;
    }

    function setAdressType($adressType) {
        $this->adressType = $adressType;
    }

    function setAdressComplement($adressComplement) {
        $this->adressComplement = $adressComplement;
    }

    function setAdressDistrict($adressDistrict) {
        $this->adressDistrict = $adressDistrict;
    }

    function setAdressCity($adressCity) {
        $this->adressCity = $adressCity;
    }

    function setAdressState($adressState) {
        $this->adressState = $adressState;
    }

    function setStatus($status) {
        $this->status = $status;
    }


    
    
    
//Função que retornar o json
    function serialize(){
        
       // return json_encode(get_object_vars ($this),JSON_PRETTY_PRINT);
            return get_object_vars($this);

        
    }

}



//------

//
//if (1 > 2) { //simula session
//    echo "sem permissão";
//} else {
//
//
//    $cliente = new Client();
//
//    $cliente->setId(1);
//    $cliente->setName("Willian");
//
////echo $cliente->getClient_id(). "<br>";
////echo $cliente->getClient_name() . "<br>";
////$myJSON =  json_encode($cliente);
//
//    $myJSON = $cliente->serialize();
//
//
//
//    header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 
//    echo $myJSON;
//}
?>




