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

<html lang="en"><head>
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">

<title>TZNE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                        <style type="text/css"></style>
                        <link rel="stylesheet" type="text/css" href="http://tzne.kwcraft.com.br/admin/style.css">
                        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
                        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
                        <script type="text/javascript">
                            window.alert = function () {
                            };
                            var defaultCSS = document.getElementById('bootstrap-css');
                            function changeCSS(css) {
                                if (css)
                                    $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="' + css + '" type="text/css" />');
                                else
                                    $('head > link').filter(':first').replaceWith(defaultCSS);
                            }
                            $(document).ready(function () {
                                var iframe_height = parseInt($('html').height());
                                window.parent.postMessage(iframe_height, 'https://bootsnipp.com');
                            });
                        </script>
                    </head>
                    <body style="">
                        <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css?family=Teko:400,700" rel="stylesheet">
                        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


                        <?php  
                        include 'menu.php';
                        ?>


                        <section id="contact">
                            <div class="section-content">
                                <h1 class="section-header"><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s"> Cadastro de Produto</span></h1>
                                <h3></h3>
                            </div>
                            <!--            <div class="contact-section">-->
                            <div class="container">
                                <form enctype="multipart/form-data" id="form" name="form" method="POST" action="/admin/api/produtos/inserirproduto">

                                    <?php
    /*Aqui envio ele pelo formulário para saber se quando receber será a ação do mesmo formulário, para evitar
    vários cliques de enviado e gerar duplicidade de chamados por cliques reptidos. 
    */
    echo "<input type=hidden name='seed' value='$seed'>";

    ?>
    <div class="col-md-6 form-line">
        <div class="form-group">
            <label for="name">Nome do produto</label>
            <input type="text" class="form-control" id="txtnome" name="name" placeholder=" Nome do produto" required="required">
        </div>
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" class="form-control" id="txtnome" name="model" placeholder=" Modelo" required="required">
        </div>

        <div class="form-group">
            <label for="description"> Descrição</label>
            <textarea class="form-control" rows="3" id="txtmsg" name="description" placeholder=" Descrição" required="required"></textarea>
        </div>

        <div class="form-group">
            <label for="specification">Especificação</label>
            <textarea class="form-control" rows="3" id="txtmsg" name="specification" placeholder=" Especificação" required="required"></textarea>

        </div>

        <div class="form-group">
            <label for="code">Código</label>
            <input type="text" class="form-control" id="txtnome" name="code" placeholder=" Código" required="required">
        </div>

        <div class="form-group">
            <label for="sale_price">Preço de venda</label>
            <input type="text" class="form-control" id="txtnome" name="sale_price" placeholder=" Preço de venda" required="required">
        </div>

        <div class="form-group">
            <label for="purchase_price">Preço de compra</label>
            <input type="text" class="form-control" id="txtnome" name="purchase_price" placeholder=" Preço de venda" required="required">
        </div>


        <div class="form-group">
            <label for="profit_margin">Margem de lucro</label>
            <input type="text" class="form-control" id="txtnome" name="profit_margin" placeholder=" Margem de lucro" required="required">
        </div>


        <div class="form-group">
            <label for="promotional_price">Preço promocional</label>
            <input type="text" class="form-control" id="txtemail" name="promotional_price" placeholder=" Preço promocional" required="required">
        </div>	
        <div class="form-group">
            <label for="length">Comprimento</label>
            <input type="text" class="form-control" id="txttel" name="length" placeholder=" Comprimento" required="required">
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="width">Largura</label>
            <input type="text" class="form-control" id="chamado" name="width" placeholder=" Largura" required="required">
        </div>

        <div class="form-group">
            <label for="heigth">Altura</label>
            <input type="text" class="form-control" id="chamado" name="heigth" placeholder=" Altura" required="required">
        </div>


        <div class="form-group">
            <label for="width">Status</label>
            <select class="form-control" name="status" required="required">
                <option value="1">Ativo</option>
                <option value="0">Desativado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product_stock_quantity">Quantidade em estoque </label>
            <input type="text" class="form-control" id="chamado" name="product_stock_quantity" placeholder=" Quantidade em estoque " required="required">
        </div>
        <div class="form-group">
            <!-- <label for="brands_brand_id">Marca</label> -->
            <input type="hidden" class="form-control" id="chamado" name="brands_brand_id" placeholder=" Marca" value="1">
        </div>
<div class="form-group">
            <label for="departaments_departament_id">Departamento</label>
                 <label for="width">Tamanho</label>
            <select class="form-control" name="departaments_departament_id" required="required">

  <?php
                $departamentos = json_decode(file_get_contents("http://tzne.kwcraft.com.br/admin/api/listardepartamentos"));
/*                echo "<pre>";
                echo var_dump($departamentos);
                echo "<pre>";*/

                for($i=0; $i<sizeof($departamentos); $i++) {
                   
                   print('<option value="'.$departamentos[$i]->departament_id.'">'.$departamentos[$i]->departament_name.'</option>'."\n");
                    }
                
                
            ?>
            </select>



        </div>

        <div class="form-group">
            <!-- <label for="idcolor">Cor</label> -->
            <input type="hidden" class="form-control" id="chamado" name="idcolor" placeholder=" Largura" value="3">
        </div>


 <div class="form-group">

                 <label for="width">Tamanho</label>
            <select class="form-control" name="idsize" required="required">
       
                   <?php
                $tamanhos = json_decode(file_get_contents("http://tzne.kwcraft.com.br/api/listadetamanhos"));

                for($i=0; $i<sizeof($tamanhos); $i++) {
                    $selected = '';
                    if($tamanhos[$i]->product_id_size == $produto->options[0]->size){
                print('<option value="'.$tamanhos[$i]->product_id_size.'"'.$selected.' selected>'.$tamanhos[$i]->product_size.'</option>'."\n");
                    }else
                    {
                    print('<option value="'.$tamanhos[$i]->product_id_size.'"'.$selected.'>'.$tamanhos[$i]->product_size.'</option>'."\n");
                    }
                }
                
            ?>



<!--                  <option value="<?php echo $produto->status?>" selected><?php echo $status?></option>
 -->       
            </select>


        </div>

<!--         <div class="form-group">
            <label for="img_relative_url">URL da imagem</label>
            <input type="text" class="form-control" id="chamado" name="img_relative_url" placeholder=" Largura">
        </div> -->

        <div class="form-group">
            <label for="foto">Imagem</label>
            <input  type="file" class="form-control-file" idaria-describedby="fileHelp" name="foto" required="required">
        </div>





        <div>

            <button type="submit" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Enviar</button>
              <a href="http://tzne.kwcraft.com.br/admin/listarprotocolos?pagina=1" style="margin-bottom: 20px" class="btn btn-default danger"><i class="fa fa-reply" aria-hidden="true"></i>  Voltar</a>
        </div>

    </div>
</form>
</div>
<!--</div>-->
</section>
<script type="text/javascript">

</script>


</body></html>