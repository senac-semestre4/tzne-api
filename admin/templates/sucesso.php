<?php
ini_set( 'display_errors', '0');
$msgSucesso = $_GET['msgSucesso'];
$mgsVoltar = $_GET['mgsVoltar'];
$href =$_GET['href'];

?>


    <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="robots" content="noindex, nofollow">

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
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-success col-xs-6 col-md-offset-3" role="alert"><?php echo $msgSucesso;?></div>

                        <div class="col-xs-12">
                            <a  class="btn btn-info" href="<?php echo $href?>"><?php echo $mgsVoltar?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
