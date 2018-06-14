<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Cadastra Usúario" content="">
    <title>Cadastra Usúario</title>

    <!-- DEPENDENCIAS DE TERCEIROS-->
    <!-- jquery -->
    <script src="JS/LIBS/jquery-3.2.1/jquery-3.2.1.min.js"></script>
    <!-- materialize -->
    <script src="JS/LIBS/materialize-0.100.1/js/materialize.js"></script>
    <link rel="stylesheet" href="JS/LIBS/materialize-0.100.1/css/materialize.css">
    <!-- dataTables -->
    <script type="application/javascript" src="JS/LIBS/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="JS/LIBS/jquery.dataTables.min.css"/>

    <!-- ESTILO CUSTOMIZADO -->
    <link rel="stylesheet" type="text/css" href="CSS/loading.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/customModal.css"/>

    <link rel="stylesheet" type="text/css" href="CSS/cadUsuarioPage.css"/>

    <!-- JS CUSTOMIZADO -->
    <script src="JS/Util/customModal.js"></script>
    <script src="JS/Util/customLoading.js"></script>
    <script src="JS/Util/RESTClient.js"></script>
    <script src="JS/CadastraUsuarioViewModel.js"></script>

</head>
<body>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col ">

            <div class="row ">
                <div class="input-field col ">
                    <input size="50%" id="inputNome" name="inputNome" type="text">
                    <label class="center-align">Nome Completo</label>
                </div>
                <div class="input-field col ">
                    <input size="30%" type="text" id="inputLogin" name="inputLogin">
                    <label class="center-align">Login</label>
                </div>
                <div class="input-field col ">
                    <select size="50%" id="selectPerfil" name="selectPerfil">
                        <option value="" disabled selected>Selecione</option>
                        <option value="1">Padrão</option>
                        <option value="2">Super</option>
                        <option value="3">Administrador</option>
                    </select>
                    <label class="center-align">Perfil</label>
                </div>
                <div class="customInputField col ">
                    <input type="checkbox" id="checkboxAtivo" name="checkboxAtivo" checked/>
                    <label for="checkboxAtivo">Ativo</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <a href="#" class="btn waves-effect waves-light col s12">Cadastrar</a>
                </div>
            </div>


        </div>
    </div>
    <div class="row">
        <div class="col">
            <table id="tableUsuarios" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Login</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<!-- CUSTOM LOADING -->
<div id="loading" class="loadingOuter">
    <div class="loadingInner">
        <img class="loadingImage" src="IMG/loading2.gif">
        <br>
        <span class="loadingText">Carregando...</span>
    </div>
</div>

</body>
</html>