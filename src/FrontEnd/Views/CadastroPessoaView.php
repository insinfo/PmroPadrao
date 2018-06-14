<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="PMRO Padrão LIB" content="">
    <meta name="Isaque" content="">
    <title>Cadastro de Pessoa</title>

    <link rel="stylesheet" href="CSS/switcher.css">
    <link rel="stylesheet" type="text/css" href="CSS/style.css"/>
    <!-- DEPENDENCIAS CSS DE TERCEIROS-->
    <link rel="stylesheet" href="JS/LIBS/bootstrap-4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="JS/LIBS/jquery.dataTables.min.css"/>
    <!-- DEPENDENCIAS JS DE TERCEIROS-->
    <script src="JS/LIBS/jquery-3.2.1/jquery-3.2.1.min.js"></script>
    <script src="JS/LIBS/popper-1.11.0/popper.min.js"></script>
    <script src="JS/LIBS/bootstrap-4.0.0-beta/js/bootstrap.min.js"></script>
    <!-- DEPENDENCIAS DA VIEWMODEL DE TERCEIROS-->
    <script type="application/javascript" src="JS/LIBS/jquery.dataTables.min.js"></script>
    <script type="application/javascript" src="JS/LIBS/jquery.mask.min.js"></script>
    <!-- DEPENDENCIAS DA VIEWMODEL -->
    <script type="application/javascript" src="JS/LIBS/dynamicListener.min.js"></script>
    <script type="application/javascript" src="JS/Util/RESTClient.js"></script>
    <script type="application/javascript" src="JS/Util/utils.js"></script>
    <!-- GARREGA O VIEWMODEL  -->
    <script type="application/javascript" src="JS/PessoaViewModel.js"></script>
</head>
<body>
<form id="formCadPessoa">

    <div class="container-fluid" id="containerBody" style="background: #ffffff">
        <!-- HEADER  -->
        <div class="row">
            <div class="col">
                <br>
            </div>
        </div>
        <!-- FORM  -->
        <div class="row">
            <!-- COLUNA 1 -->
            <div class="col">
                <!-- INICIO TAB BAR PESSOA -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" data-toggle="tab" href="#pfisica" id="btnTabPessoaFisica">
                            Pessoa Física
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" data-toggle="tab" href="#pjuridica" id="btnTabPessoaJuridica">
                            Pessoa Jurídica
                        </a>
                    </li>
                </ul>
                <!-- FIM TAB BAR PESSOA -->
                <br>
                <input type="hidden" class="form-control" name="tipoPessoa" value="Fisica" id="tipoPessoa">

                <div class="form-group row ">
                    <label class="col-sm-3 col-form-label ">Nome</label>
                    <div class="col-sm-8">
                        <input class="form-control " type="text" name="nomePessoa" maxlength="50" id="nomePessoa"
                               placeholder="" required>
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-3 col-form-label ">Email Principal</label>
                    <div class="col-sm-8">
                        <input class="form-control " type="text" name="emailPrincipal" maxlength="50"
                               id="emailPrincipal" placeholder="">
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-3 col-form-label ">Email Adicional</label>
                    <div class="col-sm-8">
                        <input class="form-control " type="text" name="emailAdicional" maxlength="50"
                               id="emailAdicional" placeholder="">
                        <small class="form-control-feedback"></small>
                    </div>
                </div>
                <!-- Início corpo do painel de abas de pessoa -->
                <div class="tab-content">
                    <!-- PESSOA FÍSICA -->
                    <div class="tab-pane active" role="tabpanel" id="pfisica">
                        <div class="form-group row " id="cpfGroup">
                            <label class="col-sm-3 col-form-label ">CPF</label>
                            <div class="col-sm-8 ">
                                <input class="form-control form-control-danger" type="text" name="cpf"
                                       maxlength="14"
                                       id="cpf" placeholder="">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">RG</label>
                            <div class="col-sm-8">
                                <input class="form-control " type="text" name="rg" maxlength="50" id="rg"
                                       placeholder="">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row " id="dataEmissaoGroup">
                            <label class="col-sm-3 col-form-label ">Data Emissão</label>
                            <div class="col-sm-8">
                                <input class="form-control " type="text" name="dataEmissao" id="dataEmissao"
                                       placeholder="">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Orgão Emissor</label>
                            <div class="col-sm-8">
                                <input class="form-control " type="text" name="orgaoEmissor" id="orgaoEmissor"
                                       placeholder="">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Estado Emisão</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="ufOrgaoEmissor">
                                    <option selected>Selecione</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Nacionalidade</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="paisNacionalidade">
                                    <option selected>Selecione</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row " id="dataNascimentoGroup">
                            <label class="col-sm-3 col-form-label ">Nascimento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dataNascimento">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Sexo</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexo" id="sexo">
                                    <option value="" selected>Selecione</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Masculino">Masculino</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Pessoa Física -->

                    <!-- Form Pessoa Jurídica -->
                    <div class="tab-pane" role="tabpanel" id="pjuridica">
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">CNPJ</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="" name="cnpj" id="cnpj">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Nome Fantasia</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="" name="nomeFantasia"
                                       id="nomeFantasia">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-4 col-form-label ">Inscrição Estadual</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="" name="inscricaoEstadual"
                                       id="inscricaoEstadual">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                    </div>
                    <!-- Fim Pessoa Jurídica -->

                </div>
            </div>
            <!-- COLUNA 2 -->
            <div class="col">
                <!-- BLOCO TELEFONES -->

                <ul class="nav nav-tabs" role="tablist" id="tabBarPhones">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" data-toggle="tab" href="#tabPhone1">Telefone 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" data-toggle="tab" href="#tabPhone2"
                           id="btnShowTabPhone2">+</a>
                    </li>
                </ul>
                <!-- Inicia corpo do painel container de abas de telefone -->
                <div class="tab-content" id="containerTabsPhones">

                    <!-- Inícios Telefone 1 -->
                    <div class="tab-pane active" role="tabpanel" id="tabPhone1">
                        <br>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Tipo</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="tipoTelefone">
                                    <option value="Residencial">Residencial</option>
                                    <option value="Comercial">Comercial</option>
                                    <option value="Móvel" selected>Móvel</option>
                                    <option value="Outro">Outro</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Telefone</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" name="numeroTelefone">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Telefone 1 -->
                    <!-- Inícios Telefone 2 -->
                    <div class="tab-pane" role="tabpanel" id="tabPhone2">
                    </div>
                    <!-- Fim Telefone 2 -->
                    <!-- Inícios Telefone 3 -->
                    <div class="tab-pane" role="tabpanel" id="tabPhone3">
                    </div>
                    <!-- Fim Telefone 3 -->
                </div>
                <!-- Fim container de abas de telefones -->

                <!-- BLOCO ENDEREÇOS -->
                <ul class="nav nav-tabs" role="tablist" id="tabBarEnderecos">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" data-toggle="tab" href="#tabEndereco1">Endereço 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" data-toggle="tab" href="#tabEndereco2"
                           id="btnShowTabEndereco2">+</a>
                    </li>
                </ul>
                <!-- Inícios Panel body Endereços -->
                <div class="tab-content" id="containerTabsEnderecos">
                    <!-- Inícios Endereço 1 -->
                    <div class="tab-pane active" role="tabpanel" id="tabEndereco1">
                        <br>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">CEP</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="cep" type="text" maxlength="8" minlength="8"
                                       onfocus="preventsLetter(this)">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label "></label>
                            <div class="col-sm-4">
                                <button class="btn btn-primary larguraTotal" type="button" name="btnBuscarEndereco">
                                    Preencher endereço
                                </button>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary larguraTotal" type="button" data-toggle="modal"
                                        data-target="#modalCEP"
                                        name="btnEncontrarCEP">
                                    Buscar CEP
                                </button>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Tipo</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="tipoEndereco">
                                    <option value="Residencial">Residencial</option>
                                    <option value="Comercial">Comercial</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">País</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="pais">
                                    <option value="" selected>Selecione</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">UF</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="uf" disabled>
                                    <option value="" selected>Selecione</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Municipio</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="municipio" disabled>
                                    <option value="" selected>Selecione</option>
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Bairro</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="bairro" type="text" maxlength="70"
                                       onfocus='preventsNumber(this)' disabled>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Logradouro</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="tipoLogradouro" disabled>
                                    <option value="" selected>Selecione</option>
                                    <option value="Rua">Rua</option>
                                    <option value="Avenida">Avenida</option>
                                    <option value="Beco">Beco</option>
                                    <option value="Estrada">Estrada</option>
                                    <option value="Praça">Praça</option>
                                    <option value="Rodovia">Rodovia</option>
                                    <option value="Travessa">Travessa</option>
                                    <option value="Largo">Largo</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="logradouro" disabled>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm-3">
                                <label>Marque aqui</label>
                            </div>
                            <div class="col-sm-2">
                                <input id="enderecoDivergente" name="enderecoDivergente" value="false"
                                       onclick="$(this).val(this.checked ? 'true' : 'false')"
                                       class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                <label for="enderecoDivergente"></label>
                            </div>
                            <div class="col-sm-7 padding5">
                                caso o endereço dos correios seja divergente
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Número</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="numeroLogradouro" type="text" maxlength="10"
                                       onfocus='preventsLetter(this)'>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label ">Complemento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="complemento" maxlength="70">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <!--  -->
                        <input type="hidden" name="validaoCorreios" value="false"/>

                    </div>
                    <!-- Fim Endereço 1 -->
                    <!-- Início Endereço 2 -->
                    <div class="tab-pane" role="tabpanel" id="tabEndereco2">
                    </div>
                    <!-- Fim Endereço 2 -->
                    <!-- Início Endereço 3 -->
                    <div class="tab-pane" role="tabpanel" id="tabEndereco3">
                    </div>
                    <!-- Fim Endereço 3 -->
                </div>
            </div>
        </div>
        <!-- FOOTER  -->
        <div class="row">
            <!-- RODAPE FORMULARIO -->
            <div class="col">
                <input type="submit" style="width:100%;" class="btn btn-primary" name="salvar" value="Salvar"
                       id="btnSalvar"/>
                <p></p>
            </div>
        </div>

    </div><!-- container -->

    <!-- Modal Buscar CEP -->
    <div class="modal fade" id="modalCEP" tabindex="-1" role="dialog">
        <div class="modal-dialog modalLarge" role="document">
            <div class="modal-content">
                <form name="formBuscaCEP" id="formBuscaCEP">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Busca CEP atraves de endereço.</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon">UF</span>
                            <select class="form-control" name="ufBuscaCEP">
                                <option value="" selected>Selecione</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Municipio</span>
                            <select class="form-control" name="municipioBuscaCEP">
                                <option value="" selected>Selecione</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Bairro</span>
                            <input type="text" class="form-control" name="bairroBuscaCEP">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Logradouro</span>
                            <input type="text" class="form-control" name="logradouroBuscaCEP">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" name="btnFechar">Fechar
                        </button>
                        <button type="button" class="btn btn-primary" id="btnBuscarCEP">Buscar</button>
                    </div>
                </form>
                <div class="tableResultsCorreios">
                    <table id="tableResultsCorreios" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Logradouro</th>
                            <th>Complemento</th>
                            <th>Bairro</th>
                            <th>Localidade</th>
                            <th>UF</th>
                            <th>CEP</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="loading" class="loadingOuter">
        <div class="loadingInner">
            <img class="loadingImage" src="IMG/loading2.gif">
            <br>
            <span class="loadingText">Carregando...</span>
        </div>
    </div>

</form>
</body>
</html>