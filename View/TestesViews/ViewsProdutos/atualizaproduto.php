
<html>
    <body>
        
    
         
                <label>Id</label>
            <br>
            <input id="id" type="text" name="id" value="" oninput="getText()">
            <br><br>
    
            <label>Nome</label>
            <br>
            <input id="nome" type="text" name="nome" value="" oninput="getText()">
            <br><br>
            <label>Modelo</label>
            <br>
            <input id="model" type="text" name="model" value="" oninput="getText()">
            <br><br>
            <label>Codigo</label>
            <br>
            <input id="code" type="text" name="code" value="" oninput="getText()">
            <br><br>
            <label>Especificação</label>
            <br>
            <input id="specification" type="text" name="specification" value="Espec" oninput="getText()">
            <br><br>
            
            <label>Preço de venda</label>
            <br>
            <input id="purchase_price" type="text" name="purchase_price" value="" oninput="getText()">
            <br><br>
            <label>Margem de lucro</label>
            <br>
            <input id="profit_margin" type="text" name="profit_margin" value="" oninput="getText()">
            <br><br>
            <label>Preço promocional</label>
            <br>
            <input id="promotional_price" type="text" name="promotional_price" value="" oninput="getText()">
            <br><br>
            
            <label>Comprimento</label>
            <br>
            <input id="length" type="text" name="length" value="" oninput="getText()">
            <br><br>
            <label>Largura</label>
            <br>
            <input id="width" type="text" name="width" value="" oninput="getText()">
            <br><br>
            <label>Altura</label>
            <br>
            <input id="heigth" type="text" name="heigth" value="" oninput="getText()">
            <br><br>
            
            <label>Status</label>
            
            <select id="status" name="status" onchange="getText()">
                <option  value="1">Ativo</option>
                <option  value="0">Desativado</option>
            </select>
            <br><br>
            <label>Quantidade em estoque</label>
            <br>
            <input id="product_stock_quantity" type="text" name="product_stock_quantity" value="" oninput="getText()">
            <br><br>
            <label>Id da marca</label>
            <br>
            <input id="brands_brand_id" type="text" name="brands_brand_id" value="" oninput="getText()">
            <br><br>
            
            <label> Id do departamento</label>
            <br>
            <input id="departaments_departament_id" type="text" name="departaments_departament_id" value="" oninput="getText()">
            <br><br>
            <label>Id da cor</label>
            <br>
            <input id="idcolor" type="text" name="idcolor" value="" oninput="getText()">
            <br><br>
            <label>Id do tamanho </label>
            <br>
            <input id="idsize" type="text" name="idsize" value="" oninput="getText()">
            <br><br>
            
            <label>URL da imagem</label>
            <br>
            <input id="img_relative_url" type="text" name="img_relative_url" value="urls teste" oninput="getText()">
            <br><br>
            
            <br><br>
            
            
            <input type="button" value="Pesquisar" onclick="pesquisar()">
            <input type="button" value="Atualizar" onclick="atualizar()">

        
              <p id="demo"></p>
        <script>
     var id;
     var idcor;
     var idtam;
     var nome;
     var modelo;
     var code;
     var specification;
     var purchase_price;
     var profit_margin;
     var promotional_price;
     var length;
     var width;
     var heigth;
     var status;
     var product_stock_quantity;
     var brands_brand_id;
     var departaments_departament_id;
     var idcolor;
     var idsize;
     var img_relative_url;
     
     
     
     
     var myObj;
     var myObj2;
     
        //função que pega os dados dos inputs em tempo real
        //passando seus valores para as respctivas variáveis
                function getText() {
                                    id = document.getElementById("id").value;
                                    nome = document.getElementById("nome").value;
                                    modelo = document.getElementById("model").value;
                                    code = document.getElementById("code").value;
                                    specification = document.getElementById("specification").value;
                                    purchase_price = document.getElementById("purchase_price").value;
                                    profit_margin = document.getElementById("profit_margin").value;
                                    promotional_price = document.getElementById("promotional_price").value;
                                    length = document.getElementById("length").value;
                                    width = document.getElementById("width").value;
                                    heigth = document.getElementById("heigth").value;
                                    status = document.getElementById("status").value;
                                    product_stock_quantity = document.getElementById("product_stock_quantity").value;
                                    brands_brand_id = document.getElementById("brands_brand_id").value;
                                    departaments_departament_id = document.getElementById("departaments_departament_id").value;
                                    idcolor = document.getElementById("idcolor").value;
                                    idsize = document.getElementById("idsize").value;
                                    img_relative_url = document.getElementById("img_relative_url").value;
    }
    //Função responsável por buscar e colocar nos inputs o resultado da busca
    //feita pelo cod, idcor e idtam do produto.
    function pesquisar() {
     
        
        var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
              //Recebe o objeto um para quando acionar o pesquisar e outro
            //para quando acionar o atualizar  
              myObj = JSON.parse(this.responseText);
              myObj2 = this.responseText;
                //Setando os campos
                document.getElementById("id").value = myObj.product_id;
                document.getElementById("nome").value = myObj.product_name;
                document.getElementById("model").value = myObj.product_model;
                document.getElementById("code").value = myObj.product_code;
                document.getElementById("specification").value = myObj.product_specification;
                document.getElementById("purchase_price").value = myObj.product_purchase_price;
                document.getElementById("profit_margin").value = myObj.product_profit_margin;;
                document.getElementById("promotional_price").value = myObj.product_promotional_price;
                document.getElementById("length").value = myObj.product_length;
                document.getElementById("width").value = myObj.product_length;
                document.getElementById("heigth").value = myObj.product_heigth;
                document.getElementById("status").value = myObj.product_status;
                document.getElementById("status").value = myObj.product_status;
                document.getElementById("product_stock_quantity").value = myObj.product_quantity;
                document.getElementById("brands_brand_id").value = myObj.brands_brand_id;
                document.getElementById("departaments_departament_id").value = myObj.departaments_departament_id;
                document.getElementById("departaments_departament_id").value = myObj.departaments_departament_id;
                document.getElementById("idcolor").value = myObj.products_color_product_id_color;
                document.getElementById("idsize").value = myObj.products_size_product_id_size;
        }
      };
      //Método POST, url e assícrono
      xhttp.open("POST", "/Controller/ListarProdutoCaracteristica.php", true);
      //Configurando o header
      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      //Enviando os parâmetros da busca
      xhttp.send("id="+id+"&idcor="+idcolor+"&idsize="+idsize);
    }
    
    
    //Funcão atualizar, responsável por pegar os dados que foram alterados e atualizar no banco
    //Como é apenas para teste, os campos a serem atualizados são nome e modelo
    function atualizar(){
        //faz o parse para possibilitar a edição do obj
        var x=  JSON.parse(myObj2); 
            //Configura os dados alterados

            x.product_id =  id;
            x.product_name = nome;
            x.product_model = modelo;
            x.product_code = code;
            x.product_specification = specification; 
            x.product_purchase_price = purchase_price;
            x.product_profit_margin =  profit_margin;
            x.product_promotional_price = promotional_price;
            x.product_length = length;
            x.product_width = width; 
            x.product_heigth = heigth;
            x.product_status = status;
            x.product_quantity = product_stock_quantity;
            x.brands_brand_id = brands_brand_id;
            x.departaments_departament_id =  departaments_departament_id;
            x.products_color_product_id_color = idcolor;
            x.products_size_product_id_size = idsize;
        
       //Torna o x novamente em string json, para poder enviar via POST 
       var param = JSON.stringify(x);
       

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Dados Atualizados");
        }
      };
      xhttp.open("POST", "/Controller/AtualizaProduto.php", true);
      xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      //Envia o objeto para o arquivo php tratar a atualização  
      xhttp.send(param);
        
        
    }
    
        </script>

    </body>
</html>
    




