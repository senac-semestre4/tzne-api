
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
            <input id="code" type="text" name="code" value="1" oninput="getText()">
            <br><br>
            <label>Id da cor</label>
            <br>
            <input id="fk_product_id_color" type="text" name="fk_product_id_color" value="1" oninput="getText()">
            <br><br>
            <label>Id do tamanho </label>
            <br>
            <input id="fk_product_size_id" type="text" name="fk_product_size_id" value="1" oninput="getText()">
            <br><br>
            
            
            <input type="button" value="Pesquisar" onclick="pesquisar()">
            <input type="button" value="Atualizar" onclick="atualizar()">
            <br><br>

              <p id="demo"></p>
        <script>
     var code;
     var idcor;
     var idtam;
     var nome;
     var modelo;
     var myObj;
     var myObj2;
     
        //função que pega os dados dos inputs em tempo real
        //passando seus valores para as respctivas variáveis
        function getText() {
            code = document.getElementById("code").value;
            idcor = document.getElementById("fk_product_id_color").value;
            idtam = document.getElementById("fk_product_size_id").value;
            nome = document.getElementById("nome").value;
            modelo = document.getElementById("model").value;
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
                document.getElementById("fk_product_id_color").value = myObj.fk_product_id_color;
                document.getElementById("fk_product_size_id").value = myObj.fk_product_size_id;
                
        }
      };
      //Método POST, url e assícrono
      xhttp.open("POST", "/Controller/ListarProdutoCaracteristica.php", true);
      //Configurando o header
      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      //Enviando os parâmetros da busca
      xhttp.send("code="+code+"&fk_product_id_color="+idcor+"&fk_product_size_id="+idtam);
    }
    
    
    //Funcão atualizar, responsável por pegar os dados que foram alterados e atualizar no banco
    //Como é apenas para teste, os campos a serem atualizados são nome e modelo
    function atualizar(){
        //faz o parse para possibilitar a edição do obj
        var x=  JSON.parse(myObj2); 
            //Configura os dados alterados
            x.product_name =  nome;
            x.product_model = modelo;
        
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
    




