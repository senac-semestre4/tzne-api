

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

       



        <section id="contact">
            <div class="section-content">
                <h1 class="section-header"><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s">TZNE - Tela de Login</span></h1>
                <h3></h3>
            </div>
            <!--            <div class="contact-section">-->
            <div class="container">
                <form id="form" name="form" method="POST" action="/Services/LoginUsuario.php">
                    <div class="col-md-6 col-sm-offset-3 form-line">
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" id="txtnome" name="username" placeholder=" Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="txtnome" name="password" placeholder=" Senha">
                        </div>

                        <div>

                            <button type="submit" class="btn btn-default submit"><i  aria-hidden="true"></i>  Entrar</button>
                        </div>

                    </div>
                </form>
            </div>
            <!--</div>-->
        </section>
        <script type="text/javascript">

        </script>


    </body></html>
