<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="PMRO Padrão LIB" content="">
    <meta name="Isaque" content="">
    <title>PMRO Padrão LIB</title>

    <!-- Bootstrap core CSS -->
    <link href="JS/LIBS/sb-admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="JS/LIBS/sb-admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="JS/LIBS/sb-admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="JS/LIBS/sb-admin/css/sb-admin.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="JS/LIBS/sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="JS/LIBS/sb-admin/vendor/popper/popper.min.js"></script>
    <script src="JS/LIBS/sb-admin/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="JS/LIBS/sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="JS/LIBS/sb-admin/vendor/chart.js/Chart.min.js"></script>
    <script src="JS/LIBS/sb-admin/vendor/datatables/jquery.dataTables.js"></script>
    <script src="JS/LIBS/sb-admin/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for this  -->
    <script src="JS/LIBS/sb-admin/sb-admin.js"></script>
    <style>

        html, body{
            height: 100%;
        }

        .containerCuston {
            height: 100%;
            overflow: hidden;
        }

        .iframe {
            margin: 0;
            padding: 0;
            border: none;
            width: 100%;
            height: 100%;
        }

    </style>

</head>

<body class="fixed-nav" id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    <a class="navbar-brand" href="#">PMRO PADRÃO LIB</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav">
            <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="#">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">
                Cadastra Pessoa</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Lista Pessoa">
                <a class="nav-link" href="#">
                    <i class="fa fa-fw fa-area-chart"></i>
                    <span class="nav-link-text">
                Lista Pessoa</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Cadastra Usuario">
                <a class="nav-link" href="http://pmropadrao.lib.com/PmroPadraoLib/View/CadastraUsuarioView.php" target="iframeShowPage">
                    <i class="fa fa-fw fa-table"></i>
                    <span class="nav-link-text">
                Contas de Usúario</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents">
                    <i class="fa fa-fw fa-wrench"></i>
                    <span class="nav-link-text">
                Outros</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponents">
                    <li>
                        <a href="#">Opção 1</a>
                    </li>
                    <li>
                        <a href="#">Opção 2</a>
                    </li>
                    <li>
                        <a href="#">Opção 3</a>
                    </li>
                    <li>
                        <a href="#">Opção 4</a>
                    </li>
                </ul>
            </li>
        </ul>

        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <!-- Mensagens e Alertas -->
        <ul class="navbar-nav ml-auto">
            <!-- Mensagens -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="messagesDropdown" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-envelope"></i>
                    <span class="d-lg-none">Messages
                <span class="badge badge-pill badge-primary">12 New</span>
              </span>
                    <span class="new-indicator text-primary d-none d-lg-block">
                <i class="fa fa-fw fa-circle"></i>
                <span class="number">12</span>
              </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">Menssages:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>Isaque Neves</strong>
                        <span class="small float-right text-muted">11:21</span>
                        <div class="dropdown-message small">Bom dia, tem que cadastrar fulano.
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>João</strong>
                        <span class="small float-right text-muted">11:21</span>
                        <div class="dropdown-message small">Já cadastrou
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">
                        Ver todos as mensagens.
                    </a>
                </div>
            </li>
            <!-- Alertas -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning">6 New</span>
              </span>
                    <span class="new-indicator text-warning d-none d-lg-block">
                <i class="fa fa-fw fa-circle"></i>
                <span class="number">6</span>
              </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">Novos Alertas:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up"></i>
                    Atualização de Status</strong>
                </span>
                        <span class="small float-right text-muted">11:21</span>
                        <div class="dropdown-message small">Isto é uma mensagem automatica do servidor. Ouve um erro.
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                <span class="text-danger">
                  <strong>
                    <i class="fa fa-long-arrow-down"></i>
                    Atualização de Status</strong>
                </span>
                        <span class="small float-right text-muted">11:21</span>
                        <div class="dropdown-message small">Isto é uma mensagem automatica do servidor. Todos os
                            sistemas online.
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up"></i>
                    Atualização de Status</strong>
                </span>
                        <span class="small float-right text-muted">11:21</span>
                        <div class="dropdown-message small">Isto é uma mensagem automatica do servidor. Todos os
                            sistemas online.
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">
                        Ver todos os alertas
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0 mr-lg-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pesquisar por...">
                        <span class="input-group-btn">
                  <button class="btn btn-primary" type="button">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>
                    Sair</a>
            </li>
        </ul>
    </div>
</nav>
<!-- <div class="content-wrapper py-3"> -->
<div class="content-wrapper containerCuston">

    <!-- <div class="container-fluid"></div>-->

    <iframe src="CadastroPessoaView.php" class="iframe" id="iframeShowPage" name="iframeShowPage" allowtransparency="true"></iframe>


</div>


<!-- Logout Modal  <iframe src="CadastroPessoaView.php"></iframe> -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
