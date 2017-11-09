<?php

error_reporting(0);
/*$mailer = new PHPMailer();
    echo '<pre>';
  echo  var_dump( get_object_vars($mailer));
    echo '</pre>';
*/
    

If (isset($_POST['txtdest']))
{
    require_once('class.phpmailer.php');
    $mailer = new PHPMailer();
    $destino = $_POST['txtdest'];
    $assunto = $_POST['txtass'];
    $mensagem = "DE: ".$destino.  "\nMensagem:\n\n".  $_POST['txtmsg'] ;
    $mailer->IsSMTP();
    $mailer->SMTPDebug = 0;
    $mailer->Port = 465; //Indica a porta de conexão para a saída de e-mails
    $mailer->Host = 'smtp.gmail.com'; //smtp.dominio.com.br
    $mailer->SMTPAuth = true; //define se haverá ou não autenticação no SMTP ssl://smtp.googlemail.com
    $mailer->SMTPSecure = 'ssl';  
    $mailer->Username = 'contatotzne@gmail.com'; //Informe o e-mai o completo
    $mailer->Password = 'contatotzne123456'; //Senha da caixa postal
    $mailer->FromName = $assunto; //Nome que será exibido para o destinatário
    $mailer->From = 'contatotzne@gmail.com'; //Obrigatório ser a mesma caixa postal indicada em "username"
    $mailer->AddAddress(/*$destino,*/'contatotzne@gmail.com'); //Destinatários
    $mailer->Subject = $assunto;
    $mailer->Body = $destino;
    $mailer->Body = $mensagem;
    $mailer->Send();


header('Content-Type: application/json');
$myObj->status = "enviada";


$myJSON = json_encode($myObj, JSON_PRETTY_PRINT);

echo $myJSON;
   
}
else
{ ?>
<html>
   <head>
       <title></title>
       <style type="text/css">
           #Text1
           {
               width: 287px;
           }
           #Text2
           {
               width: 287px;
           }
           #Text3
           {
               width: 287px;
           }
           #Text4
           {
               width: 287px;
           }
           #btEnviar
           {
               width: 100px;
           }
           #btLimpar
           {
               width: 100px;
           }
           #TextArea1
           {
               width: 287px;
           }
       </style>
   </head>
   <body>
   <form id="form" name="form" method="POST" action="/contato">
       <h2 align="center" style="text-decoration: underline"> Formulário de Contato</h2>
       <table width="450px" align="center" border="1" cellpadding="5" cellspacing="5">
           <tr>
               <td align="right">
                   Seu email:</td>
               <td>
                   <input id="txtdest" name="txtdest" type="text" /></td>
           </tr>
           <tr>
               <td align="right">
                   Assunto:</td>
               <td>
                   <input id="txtass" name="txtass" type="text" /></td>
           </tr>
           <tr>
               <td align="right">
                   Mensagem:</td>
               <td>
                   <textarea id="txtmsg" name="txtmsg" rows="2"></textarea></td>
           </tr>
           <tr>
               <td align="center" colspan="2">
                   <table style="width:100%;" cellspacing="10">
                       <tr>
                           <td align="right">
                               <input id="btEnviar" type="submit" value="Enviar" /></td>
                           <td>
                               <input id="btLimpar" type="reset" value="Limpar" align="left" /></td>
                       </tr>
                   </table>
               </td>
           </tr>
       </table>
       </form>
   </body>
</html>
<?php } ?>