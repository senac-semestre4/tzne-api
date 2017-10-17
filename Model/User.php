<?php


class User {
    private $id;
    private $userName;   
    private $userPassword;
    
    function __construct($userName, $userPassword) {
        $this->userName = $userName;
        $this->userPassword = $userPassword;
    }

    function getId() {
        return $this->id;
    }

    function getUserName() {
        return $this->userName;
    }

    function getUserPassword() {
        return $this->userPassword;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setUserPassword($userPassword) {
        $this->userPassword = $userPassword;
    }



    

}

?>
