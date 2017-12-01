<?php
//Verifico se há sessão aberta, se não abre uma nova
    if (!isset($_SESSION)) {
                session_start();
                    } else {
                        //echo"ja tem sessao";
                    }


$seed = rand(); // gero um número aleatório

$_SESSION['seed'] = $seed; //guardo ele na sessão



?>

<html>
   <head>
	 <meta charset="UTF-8">
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

   <?php
    /*Aqui envio ele pelo formulário para saber se quando receber será a ação do mesmo formulário, para evitar
    vários cliques de enviado e gerar duplicidade de chamados por cliques reptidos. 
    */
    echo "<input type=hidden name='seed' value='$seed'>";

    ?>
       <h2 align="center" style="text-decoration: underline"> Formulário de Contato</h2>
       <table width="450px" align="center" border="1" cellpadding="5" cellspacing="5">
           <tr>
               <td align="right">
                   Nome:</td>
               <td>
                   <input id="txtnome" name="txtnome" type="text" /></td>
           </tr>
           <tr>
               <td align="right">
                   Seu email:</td>
               <td>
                   <input id="txtdest" name="txtemail" type="text" /></td>
           </tr>
           <tr>
               <td align="right">
                   Telefone:</td>
               <td>
                   <input id="txttel" name="txttel" type="text" /></td>
           </tr>
           <tr>
               <td align="right">
                   Assunto:</td>
               <td>
                   <select id="chamado" name="chamado">
                     <option value="Elogio">Elogio</option>
                     <option value="Sugestão">Sugestão</option>
                     <option value="Reclamação">Reclamação</option>
                   </select>
                   </td>
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
