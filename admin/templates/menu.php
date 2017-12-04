<?php

 if (!isset($_SESSION)) {
            session_start();
        } else {
            //echo"ja tem sessao";
        }
        
        
echo'<nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="#">TZNE</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Produtos<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="http://tzne.kwcraft.com.br/admin/insereproduto">Cadastrar</a></li>
                                <li><a href="#">Listar - Editar</a></li>
                            </ul>
                        </li>
<!--                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Page 1-1</a></li>
                                <li><a href="#">Page 1-2</a></li>
                                <li><a href="#">Page 1-3</a></li>
                            </ul>
                        </li>
-->
                        <li class="dropdown"> 
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Protocolos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="http://tzne.kwcraft.com.br/admin/listarprotocolos  ">Listar</a></li>

                            </ul>
                        </li>
                        <!--                        <li><a href="#">Page 2</a></li>
                                                <li><a href="#">Page 3</a></li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!--                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>-->
                        <li><a href="desloga.php"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>';






?>
<h3 style="font-size: 15px; color: #eeeeee;">Você está logado como  <?php echo $_SESSION['admin'];?></h3>
