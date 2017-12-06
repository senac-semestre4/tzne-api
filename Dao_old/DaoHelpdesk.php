<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoHelpdesk
 *
 * @author Willian Vieira
 */
header('Content-Type: application/json'); // declara o json para a extensão do chrome funcionar. 
error_reporting(0);



$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/Constants.php';
require_once "MysqlConn.php";
require_once ROOT_DIR . '/Model/HelpDesk.php';

class DaoHelpdesk {

    function createProtocol(HelpDesk $h) {
        date_default_timezone_set("America/Sao_Paulo");
        $date = date('Y-m-d H:i:s');

        $conn = new MysqlConn();
        $conn->Conecta();

        $query = "INSERT INTO `helpdesk_protocols` (`id_protocol`, `client_name`, `email`, `tel`, `short_description`, `prob_reported`, `solotion`, `protocol_status`, `creation_date`, `update_date`, `end_date`, `resolved_by`) "
                . "VALUES ("
                . "NULL,"
                . "\"{$h->getClientName()}\","
                . "\"{$h->getEmail()}\","
                . "\"{$h->getTel()}\","
                . "\"{$h->getShortDescription()}\","
                . "\"{$h->getProbReported()}\","
                . "NULL,"
                . "'1',"
                . "NOW(),"
                . "NULL,"
                . "NULL,"
                . "NULL)";

        if (mysqli_query($conn->getLink(), $query)) {
            //$json = "{'protocoloinserido':'true'}";
            //  echo json_encode($json);
            return true;
        } else {
            echo mysqli_error($conn->getLink());
            $json = "[{'protocoloinserido':'false'},"
                    . "{'erro':".  mysqli_error($conn->getLink())."}]";
         
               echo json_encode($json);
            return false;
        }
    }

    function updateProtocol($idProtocol, $status, $resolvedBy, $solution) {
        $conn = new MysqlConn();
        $conn->Conecta();


        //$query = "UPDATE `helpdesk_protocols` SET protocol_status = ".$status. "WHERE id_protocol = " . $idProtocol.";";
/*
        $query = 
        "UPDATE `helpdesk_protocols`"
      . " SET "
      . "`protocol_status`= ".$status.""
      . "`solotion`= ".$solution.""
      . "`resolved_by`= ".$resolvedBy.""
      . " WHERE `id_protocol` = ".$idProtocol;*/
        
        $q=
"UPDATE `helpdesk_protocols` "
                . "SET "
                . "`solotion` = \"".$solution."\", "
                . "`protocol_status` = ".$status.", "
                . "`resolved_by` = \"".$resolvedBy."\" "
                . "WHERE `helpdesk_protocols`.`id_protocol` = {$idProtocol}";
        
        
        if (mysqli_query($conn->getLink(), $q)) {
            $json = "{'protocoloatualizado':'true'}";
            //echo json_encode($json);
        } else {
          echo var_dump(mysqli_error($conn->getLink()));
            $json = "{'protocoloatualizado':'false'}";
            //echo json_encode($json);
        }
    }
    
    function listProcotols(){
                $conn = new MysqlConn();
        $conn->Conecta();

        $query = ""
                . "SELECT * FROM `helpdesk_protocols` "
                . "INNER JOIN helpdesk_status "
                . "ON helpdesk_protocols.protocol_status = helpdesk_status.id_status order by helpdesk_protocols.id_protocol";
    
        if($result = mysqli_query($conn->getLink(), $query)){
            
                 while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json
                    
                    $json[] = $row;
                 
                    
                    
                 }
                 return json_encode($json);
        }else{
            echo var_dump(mysqli_error($conn->getLink()));
        
            return false;
        }
        
        
    }
    function listProcotolsId($id){
//        echo var_dump($id);
                $conn = new MysqlConn();
        $conn->Conecta();

        $query = ""
                . "SELECT `helpdesk_protocols`.*, `helpdesk_status`.`name_status`
FROM `helpdesk_protocols`
LEFT JOIN `helpdesk_status` ON `helpdesk_protocols`.`protocol_status` = `helpdesk_status`.`id_status` 
WHERE `id_protocol` = 
".$id;
    
        if($result = mysqli_query($conn->getLink(), $query)){
            
                 while ($row = mysqli_fetch_assoc($result)) {

                    //armazena linha em cada posição do array json
                    
                    $json[] = $row;
                 
                    
                    
                 }
             //    return ($json);
		return json_encode($json);	 
        }else{
            echo var_dump(mysqli_error($conn->getLink()));
        
            return false;
        }
        
        
    }

}
