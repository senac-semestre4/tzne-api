<?php
$mailer = new PHPMailer();
    echo '<pre>';
  echo  var_dump( get_object_vars($mailer));
    echo '</pre>';

    

If (isset($_POST['txtdest']))
{
    require_once('class.phpmailer.php');
    $destino = $_POST['txtdest'];
    $assunto = $_POST['txtass'];
    $mensagem = $_POST['txtmsg'];
    $mailer->IsSMTP();
    $mailer->SMTPDebug = 1;
    $mailer->Port = 587; //Indica a porta de conexão para a saída de e-mails
    $mailer->Host = 'plesk12l0003.hospedagemdesites.ws'; //smtp.dominio.com.br
    $mailer->SMTPAuth = true; //define se haverá ou não autenticação no SMTP ssl://smtp.googlemail.com
    $mailer->SMTPSecure = 'tls';  
    $mailer->Username = 'teste.suporte@lw.plesk12l0003.hospedagemdesites.ws'; //Informe o e-mai o completo
    $mailer->Password = 'Loca@102030'; //Senha da caixa postal
    $mailer->FromName = $assunto; //Nome que será exibido para o destinatário
    $mailer->From = 'teste.suporte@lw.plesk12l0003.hospedagemdesites.ws'; //Obrigatório ser a mesma caixa postal indicada em "username"
    $mailer->AddAddress($destino,'NomeDestinatário'); //Destinatários
    $mailer->Subject = $assunto;
    $mailer->Body = $mensagem;
    $mailer->Send();
    print "Mensagem enviada com sucesso!";
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
   <form id="form" name="form" method="POST" action="Mailer.php">
       <h2 align="center" style="text-decoration: underline"> Formulário de Contato (Mailer - PHP)</h2>
       <table width="450px" align="center" border="1" cellpadding="5" cellspacing="5">
           <tr>
               <td align="right">
                   Email Destinatário:</td>
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