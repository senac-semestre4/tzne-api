<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HelpDesk
 *
 * @author Willian Vieira
 */
class HelpDesk {

    private $idProtocol;
    private $clientName;
    private $email;
    private $tel;
    private $shortDescription;
    private $probReported;
    private $solotion;
    private $protocolStatus;
    private $creationDate;
    private $updateDate;
    private $endDate;
    private $resolved_by;

    function __construct() {
        
    }
    function getShortDescription() {
        return $this->shortDescription;
    }

    function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }

            
    function getIdProtocol() {
        return $this->idProtocol;
    }

    function getClientName() {
        return $this->clientName;
    }

    function getEmail() {
        return $this->email;
    }

    function getTel() {
        return $this->tel;
    }

    function getProbReported() {
        return $this->probReported;
    }

    function getSolotion() {
        return $this->solotion;
    }

    function getProtocolStatus() {
        return $this->protocolStatus;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getUpdateDate() {
        return $this->updateDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getResolved_by() {
        return $this->resolved_by;
    }

    function setIdProtocol($idProtocol) {
        $this->idProtocol = $idProtocol;
    }

    function setClientName($clientName) {
        $this->clientName = $clientName;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setProbReported($probReported) {
        $this->probReported = $probReported;
    }

    function setSolotion($solotion) {
        $this->solotion = $solotion;
    }

    function setProtocolStatus($protocolStatus) {
        $this->protocolStatus = $protocolStatus;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    function setUpdateDate($updateDate) {
        $this->updateDate = $updateDate;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function setResolved_by($resolved_by) {
        $this->resolved_by = $resolved_by;
    }

}
