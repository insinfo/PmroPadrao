<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="Login" content="">
    <title>Login</title>

    <!-- DEPENDENCIAS CSS DE TERCEIROS-->
    <link rel="stylesheet" href="JS/LIBS/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="JS/LIBS/font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- DEPENDENCIAS JS DE TERCEIROS-->
    <script src="JS/LIBS/jquery-3.2.1/jquery-3.2.1.min.js"></script>
    <script src="JS/LIBS/popper-1.11.0/popper.min.js"></script>
    <script src="JS/LIBS/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <!-- ESTILO CUSTOMIZADO -->
    <link rel="stylesheet" type="text/css" href="CSS/loginPage.css"/>

</head>
<body>
<form id="formLogin" action="mainView" method="post">
    <input type="hidden" name="_token" value="<?php echo '' ?>">
<div class="container">
    <div class="card card-container">
        <div class="row">
            <div class="col-sm-3 " align="center">
                <div class="row">
                    <div class="col">
                        <img class="logo" src="IMG/logoSISCEC.png">
                        <h6 class="bemVindo">Bem Vindo ao</h6>
                        <h1 class="sisName">PMRO Padrão</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 " align="center">
                <div class="loginForm">
                    <div class="row">
                        <div class="col">
                            <div class="right-inner-addon">
                                <input class="inputCuston" type="text" name="login" id="login" placeholder="Usúario">
                                <i class="fa fa-fw fa-user" id="iconUser"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="right-inner-addon">
                                <input class="inputCuston" type="password" name="senha" id="senha" placeholder="Senha">
                                <i class="fa fa-fw fa-unlock-alt" id="iconPassword"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="btnCuston" type="submit" value="Login">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="recoveryPass" href="#">Esqueceu a senha?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</form>
</body>
</html>