/**
 * Created by Isaque on 24/07/2017.
 */

var WEBSERVICE_BASE_URL = 'http://pmropadrao.lib.com/';

$(document).ready(function () {
    $("#containerBody").fadeIn(1000);
    var restClient = new RESTClient();
    var cadastroPessoaViewModel = new CadastroPessoaViewModel(restClient, WEBSERVICE_BASE_URL);
    cadastroPessoaViewModel.Init();
});

function CadastroPessoaViewModel(restClient, webserviceBaseURL) {
    this.correiosDataTable = null;
    this.restClient = restClient;
    this.webserviceBaseURL = webserviceBaseURL;
    this.addPhoneLimit = 1;
    this.addEnderecoLimit = 1;
    this.processing = false;
    this.formCadPessoa = 'formCadPessoa';

    this.tipoPessoa = $('[name="tipoPessoa"]');
    this.nomePessoa = $('[name="nomePessoa"]');
    this.emailPrincipal = $('[name="emailPrincipal"]');
    this.emailAdicional = $('[name="emailAdicional"]');

    this.cpf = $('[name="cpf"]');
    this.rg = $('[name="rg"]');
    this.dataEmissao = $('[name="dataEmissao"]');
    this.orgaoEmissor = $('[name="orgaoEmissor"]');
    this.ufOrgaoEmissor = $('[name="ufOrgaoEmissor"]');
    this.paisNacionalidade = $('[name="paisNacionalidade"]');
    this.dataNascimento = $('[name="dataNascimento"]');
    this.sexo = $('[name="sexo"]');

    this.cnpj = $('[name="cnpj"]');
    this.nomeFantasia = $('[name="nomeFantasia"]');
    this.inscricaoEstadual = $('[name="inscricaoEstadual"]');


}
CadastroPessoaViewModel.prototype.Init = function () {
    this.Eventos();
    this.MaskForm();
    this.GetPaises();
    this.GetUFs();
    this.GetMunicipios();
};
CadastroPessoaViewModel.prototype.ShowLoadingAnim = function () {
    this.processing = true;
    var loading = $("#loading");
    // loading.css('display', 'block');
    loading.fadeIn(500);

};
CadastroPessoaViewModel.prototype.HideLoadingAnim = function () {
    this.processing = false;
    var loading = $("#loading");
    // loading.css('display', 'none');
    loading.fadeOut(500);
};
CadastroPessoaViewModel.prototype.validaForm = function () {
    var self = this;

    if(!self.nomePessoa.val())
    {
        alert('Digite um nome!');
        return false;
    }
    if(!self.cpf.val() || !validaCPF(self.cpf.val()))
    {
        alert('Digite um CPF valido!');
        return false;
    }
    if(!self.dataNascimento.val() || !validaData(self.dataNascimento.val()))
    {
        alert('Digite uma data de nascimento!');
        return false;
    }
    if(!self.sexo.val() || self.sexo.val() == '')
    {
        alert('Selecione um sexo!');
        return false;
    }
    var telefone = $('[name="numeroTelefone"]');
    if(!telefone.val())
    {
        alert('Digite um telefone!');
        return false;
    }
    var cep = $('[name="cep"]');
    if(!cep.val())
    {
        alert('Digite um CEP, e click em preencher!');
        return false;
    }

    return true;
};
CadastroPessoaViewModel.prototype.MaskForm = function () {
    var self = this;

    this.cpf.mask('000.000.000-00', {reverse: true});
    this.dataEmissao.mask('00/00/0000');
    this.dataNascimento.mask('00/00/0000');

    //Rejeita sequencias de numeros iguais
    /* this.cep.on('input', function(e)
     {
         var regex = /^(\d)\1{3,14}$/;
         if(regex.test(cep))
         {
             alert("Numero de CEP Invalido");
         }
     });*/
};
CadastroPessoaViewModel.prototype.GetPaises = function (select) {
    var thisClas = this;
    thisClas.ShowLoadingAnim();
    this.restClient.setWebServiceURL(this.webserviceBaseURL + 'pais');
    this.restClient.setMethodGET();
    this.restClient.setSuccessCallbackFunction(function (data) {
        if (select == null)
        {
            populateSelect($('[name="pais"]'), data, 'id', 'nome', 'brasil');
            populateSelect($('[name="paisNacionalidade"]'), data, 'id', 'nome', 'brasil');
        }
        else
        {
            populateSelect(select, data, 'id', 'nome', 'brasil');
        }

        thisClas.HideLoadingAnim();

    });
    this.restClient.setErrorCallbackFunction(function (jqXHR, textStatus, errorThrown) {
        alert('Erro em obter Paises');
        thisClas.HideLoadingAnim();
    });
    this.restClient.exec();
};
CadastroPessoaViewModel.prototype.GetUFs = function (select) {
    var thisClas = this;
    thisClas.ShowLoadingAnim();
    var dataToSender = {'idPais': 33};
    this.restClient.setWebServiceURL(this.webserviceBaseURL + 'uf');
    this.restClient.setMethodPOST();
    this.restClient.setDataToSender(dataToSender);
    this.restClient.setSuccessCallbackFunction(function (data) {
        if (select == null)
        {
            populateSelect($('[name="uf"]'), data, 'id', 'nome', 'rio de janeiro');
            populateSelect($('[name="ufOrgaoEmissor"]'), data, 'id', 'nome', 'rio de janeiro');
            populateSelect($('[name="ufBuscaCEP"]'), data, 'id', 'nome', 'rio de janeiro');
        }
        else
        {
            populateSelect(select, data, 'id', 'nome', 'rio de janeiro');
        }

        thisClas.HideLoadingAnim();

    });
    this.restClient.setErrorCallbackFunction(function (jqXHR, textStatus, errorThrown) {
        thisClas.HideLoadingAnim();
        alert('Erro em obter lista de estados');
    });
    this.restClient.exec();
};
CadastroPessoaViewModel.prototype.GetMunicipios = function (idUF, select) {
    if (idUF == null)
    {
        idUF = 20;
    }
    var thisClas = this;
    thisClas.ShowLoadingAnim();
    var dataToSender = {'idUF': idUF};
    this.restClient.setWebServiceURL(this.webserviceBaseURL + 'municipio');
    this.restClient.setMethodPOST();
    this.restClient.setDataToSender(dataToSender);
    this.restClient.setSuccessCallbackFunction(function (data) {
        if (select == null)
        {
            populateSelect($('[name="municipio"]'), data, 'id', 'nome', 'rio das ostras');
            populateSelect($('[name="municipioBuscaCEP"]'), data, 'id', 'nome', 'rio das ostras');
        }
        else
        {
            populateSelect(select, data, 'id', 'nome', 'rio das ostras');
        }

        thisClas.HideLoadingAnim();

    });
    this.restClient.setErrorCallbackFunction(function (jqXHR, textStatus, errorThrown) {
        thisClas.HideLoadingAnim();
        alert('Erro em obter lista de municipios');
    });
    this.restClient.exec();
};
CadastroPessoaViewModel.prototype.GetCEPbyEndereco = function (endereco, idDivTabActive) {
    var thisClas = this;
    var dataToSender = {'endereco': endereco};
    if (this.correiosDataTable != null)
    {
        this.correiosDataTable.destroy();
    }

    this.correiosDataTable = $('#tableResultsCorreios').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
        "ajax": {
            "url": WEBSERVICE_BASE_URL + "correiosdt", "type": "POST", "data": dataToSender
        },
        "columns": [{"data": "tipo"}, {"data": "logradouro"}, {"data": "complemento"}, {"data": "bairro"}, {"data": "localidade"}, {"data": "uf"}, {"data": "cep"}],
        "searching": false,
        "ordering": false,
        "info": true
    });

    $('#tableResultsCorreios tbody').on('click', 'tr', function () {
        var data = thisClas.correiosDataTable.row(this).data();
        var cep = data['cep'].replace('-', '').trim();

        thisClas.GetEnderecoByCEP(cep, idDivTabActive);

        $('#modalCEP').modal('hide');
    });
};
CadastroPessoaViewModel.prototype.GetEnderecoByCEP = function (cep, idDivTabActive) {
    var thisClas = this;
    thisClas.ShowLoadingAnim();

    $(idDivTabActive).find('[name="bairro"]').prop('disabled', true);
    $(idDivTabActive).find('[name="uf"]').prop('disabled', true);
    $(idDivTabActive).find('[name="municipio"]').prop('disabled', true);
    $(idDivTabActive).find('[name="logradouro"]').prop('disabled', true);
    $(idDivTabActive).find('[name="tipoLogradouro"]').prop('disabled', true);

    this.restClient.setWebServiceURL(this.webserviceBaseURL + 'correios/endereco/' + cep);
    this.restClient.setMethodGET();
    this.restClient.setSuccessCallbackFunction(function (data) {
        $(idDivTabActive).find('[name="validaoCorreios"]').val('true');
        $(idDivTabActive).find('[name="cep"]').val(data['cep']);
        var pais = $(idDivTabActive).find('[name="pais"]');
        var paisOption = pais.find(" option:contains('Brasil')");
        pais.val(paisOption.val());

        var uf = $(idDivTabActive).find('[name="uf"]');

        var ufOption = uf.find(" option:contains('" + data['uf'] + "')");
        //uf.trigger("change");*///.get(0);

        if (ufOption.length > 0)
        {
            clearSelected(uf[0]);
            uf.val(ufOption.val());
        }

        var selects = document.getElementById(idDivTabActive.substring(1)).getElementsByTagName('select');
        //varre todos selects da div endereço ativa e pega o select uf
        //e dispara o evento change preenchendo o select municipio com as municipios
        //do estado do CEP e seta a municipio do CEP
        for (var i = 0; i < selects.length; i++)
        {
            (function () {

                if (selects[i].getAttribute("name") == 'uf')
                {
                    eventFire(selects[i], 'change');
                    var timerFunc = setInterval(function () {
                        if (thisClas.processing == false)
                        {
                            clearInterval(timerFunc);
                            var municipio = $(idDivTabActive).find('[name="municipio"]');
                            var municipioOption = municipio.find(" option:contains('" + data['municipio'] + "')");

                            if (municipioOption.length > 0)
                            {
                                clearSelected(municipio[0]);
                                municipio.val(municipioOption.val());
                            }
                        }
                    }, 500);
                }
            })();
        }
        $(idDivTabActive).find('[name="bairro"]').val(data['bairro']);
        $(idDivTabActive).find('[name="logradouro"]').val(data['logradouro']);
        //tipoLogradouro

        var tipoLogradouro = $(idDivTabActive).find('[name="tipoLogradouro"]');
        var tipoLogradouroOption = tipoLogradouro.find(" option:contains('" + data['tipo'] + "')");

        if (tipoLogradouroOption.length > 0)
        {
            tipoLogradouroOption.attr("selected", true);
        }
        else
        {
            tipoLogradouro.append($('<option>', {value: data['tipo'], text: data['tipo']}).attr("selected", true));
        }

        thisClas.HideLoadingAnim();
    });
    this.restClient.setErrorCallbackFunction(function (jqXHR, textStatus, errorThrown) {
        thisClas.HideLoadingAnim();
        $(idDivTabActive).find('[name="bairro"]').prop('disabled', false);
        $(idDivTabActive).find('[name="uf"]').prop('disabled', false);
        $(idDivTabActive).find('[name="municipio"]').prop('disabled', false);
        $(idDivTabActive).find('[name="logradouro"]').prop('disabled', false);
        $(idDivTabActive).find('[name="tipoLogradouro"]').prop('disabled', false);
        alert('Não foi pocivel obter endereço pelo CEP informado:');
    });
    this.restClient.exec();


};
CadastroPessoaViewModel.prototype.incluirPessoa = function (){
    var self = this;

    if(!self.validaForm())
    {
        return false;
    }

    /** OBTEM DADOS DO FORMULARIO **/
    var dataToSender = {
        'tipoPessoa': self.tipoPessoa.val(),
        'nomePessoa': self.nomePessoa.val(),
        'emailPrincipal': self.emailPrincipal.val(),
        'emailAdicional': self.emailAdicional.val(),

        'cpf': self.cpf.val().replace(/[^\d]+/g,''),
        'rg': self.rg.val(),
        'dataEmissao': self.dataEmissao.val(),
        'orgaoEmissor': self.orgaoEmissor.val(),
        'ufOrgaoEmissor': self.ufOrgaoEmissor.val(),
        'paisNacionalidade': self.paisNacionalidade.val(),
        'dataNascimento': self.dataNascimento.val(),
        'sexo': self.sexo.val(),

        'cnpj': self.cnpj.val(),
        'nomeFantasia': self.nomeFantasia.val(),
        'inscricaoEstadual': self.inscricaoEstadual.val()

    };
    self.ShowLoadingAnim();

    /** OBTEM TELEFONES **/
    var divTelefones = document.getElementById('containerTabsPhones');
    var inputsTelefone = divTelefones.querySelectorAll("input, select, checkbox, textarea");
    var telefones = [];
    var telefone = {};
    for (var j = 0, jLen = inputsTelefone.length; j < jLen; j++)
    {
        if (inputsTelefone[j].name == 'tipoTelefone')
        {
            telefone = {};
        }
        telefone[inputsTelefone[j].name] = inputsTelefone[j].value;
        if (inputsTelefone[j].name == 'numeroTelefone')
        {
            telefones.push(telefone);
        }
    }
    dataToSender['telefones'] = telefones;
    /** OBTEM ENDEREÇOS **/
    var divEnderecos = document.getElementById('containerTabsEnderecos');
    var inputsEndereco = divEnderecos.querySelectorAll("input, select, checkbox, textarea");
    var enderecos = [];
    var endereco = {};
    for (var i = 0, iLen = inputsEndereco.length; i < iLen; i++)
    {
        if (inputsEndereco[i].name == 'cep')
        {
            endereco = {};
        }
        endereco[inputsEndereco[i].name] = inputsEndereco[i].value;
        if (inputsEndereco[i].name == 'validaoCorreios')
        {
            enderecos.push(endereco);
        }
    }
    dataToSender['enderecos'] = enderecos;

    console.log(JSON.stringify(dataToSender));

    this.restClient.setWebServiceURL(this.webserviceBaseURL + 'pessoa');
    this.restClient.setMethodPOST();
    this.restClient.setDataToSender(dataToSender);
    this.restClient.setSuccessCallbackFunction(function (data) {
        self.HideLoadingAnim();
        console.log(data);
        alert('Mensagem: ' + data['message'] + ' Codigo:' + data['code']);
    });
    this.restClient.setErrorCallbackFunction(function (jqXHR, textStatus, errorThrown) {
        self.HideLoadingAnim();
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        alert(' Mensagem: Não foi pocivel salvar os dados!');
    });
    this.restClient.exec();
    return true;
};
CadastroPessoaViewModel.prototype.Eventos = function () {
    var self = this;

    $("#btnTabPessoaFisica").click(function () {

        $('#tipoPessoa').val("Fisica");
    });

    $("#btnTabPessoaJuridica").click(function () {

        $('#tipoPessoa').val("Juridica");
    });

    //Eventos das abas de telefones
    var phoneCount = 0;
    var btnShowTabPhone2 = $("#btnShowTabPhone2");
    btnShowTabPhone2.click(function ()
    {
        if (phoneCount < self.addPhoneLimit)
        {
            btnShowTabPhone2.text('Telefone 2');
            var tabPhone2 = $("#tabPhone2");
            //$("#tabPhone2").append( $("#tabPhone1").contents() );
            var tabPhone1Contents = $("#tabPhone1").children();
            tabPhone1Contents.clone(true).appendTo(tabPhone2);

            var tabBar = $('#tabBarPhones');//ul
            var tabBarItem = tabBar.find('li:last').clone(true).appendTo(tabBar);//li
            var tabBarItemLink = tabBarItem.children();//a
            tabBarItemLink.prop("id", "btnShowTabPhone3");
            tabBarItemLink.prop("href", "#tabPhone3");
            tabBarItemLink.text('+');
            tabBarItemLink.click(function () {
                tabBarItemLink.text('Telefone 3');
                var tabPhone3 = $("#tabPhone3");
                tabPhone1Contents.clone(true).appendTo(tabPhone3);
                tabBarItemLink.off('click');
            });
        }
        phoneCount++;
    });
    //Eventos das abas de enderecos
    var enderecoCount = 0;
    var btnShowTabEndereco2 = $("#btnShowTabEndereco2");
    btnShowTabEndereco2.click(function () {
        if (enderecoCount < self.addEnderecoLimit)
        {
            btnShowTabEndereco2.text('Endereço 2');
            var tabEndereco2 = $("#tabEndereco2");
            var tabEndereco1Contents = $("#tabEndereco1").children();
            tabEndereco1Contents.clone(true).appendTo(tabEndereco2);

            var tabBar = $('#tabBarEnderecos');//ul
            var tabBarItem = tabBar.find('li:last').clone(true).appendTo(tabBar);//li
            var tabBarItemLink = tabBarItem.children();//a
            tabBarItemLink.prop("id", "btnShowTabEndereco3");
            tabBarItemLink.prop("href", "#tabEndereco3");
            tabBarItemLink.text('+');
            tabBarItemLink.click(function () {
                tabBarItemLink.text('Endereço 3');
                var tabEndereco3 = $("#tabEndereco3");
                tabEndereco1Contents.clone(true).appendTo(tabEndereco3);
                tabBarItemLink.off('click');
            });
        }
        enderecoCount++;
    });

    //evento on change do select uf para obter municipios
    addDynamicEventListener(document.body, 'change', '[name="uf"]', function (e) {
        var idDivTabActive = $("ul#tabBarEnderecos li a.active").attr('href');
        var correntSelectMunicipio = $(idDivTabActive).find('[name="municipio"]');
        var correntSelectUF = $(idDivTabActive).find('[name="uf"]');
        self.GetMunicipios(correntSelectUF.val(), correntSelectMunicipio);
    });

    //evento on change do select uf para obter municipios
    addDynamicEventListener(document.body, 'change', '[name="ufBuscaCEP"]', function (e) {
        var selectUfBuscaCEP = $('[name="ufBuscaCEP"]');
        var selectMunicipioBuscaCEP = $('[name="municipioBuscaCEP"]');
        self.GetMunicipios(selectUfBuscaCEP.val(), selectMunicipioBuscaCEP);
    });
    //evento on change do select pais
    addDynamicEventListener(document.body, 'change', '[name="pais"]', function (e) {
        var idDivTabActive = $("ul#tabBarEnderecos li a.active").attr('href');
        var correntSelectPais = $(idDivTabActive).find('[name="pais"]');
        if (correntSelectPais.find("option:selected").text() != 'Brasil')
        {
            $(idDivTabActive).find('[name="municipio"]').prop('disabled', true);
            $(idDivTabActive).find('[name="uf"]').prop('disabled', true);
        }
        else
        {
            $(idDivTabActive).find('[name="municipio"]').prop('disabled', false);
            $(idDivTabActive).find('[name="uf"]').prop('disabled', false);
        }
    });

    // var btnBuscarEnderecoarray = document.getElementsByName('btnBuscarEndereco');

    /*for(var j=0; j < btnBuscarEnderecoarray.length;j++)
    {
        btnBuscarEnderecoarray[j].addEventListener("click", function(){
            alert('javascript nativo');
        });
    }*/

    /*var btnBuscarEnderecoarray = $('[name="btnBuscarEndereco"]');
    btnBuscarEnderecoarray.click(function () {
        alert('tresd 1');
    });*/

    //Buscar endeço nos correios e preencher os campos de endereço
    addDynamicEventListener(document.body, 'click', '[name="btnBuscarEndereco"]', function (e) {
        var idDivTabActive = $("ul#tabBarEnderecos li a.active").attr('href');
        var correntCep = $(idDivTabActive).find('[name="cep"]').val();
        if (correntCep == '')
        {
            alert('CEP não pode ser vazio');
        }
        else
        {
            self.GetEnderecoByCEP(correntCep, idDivTabActive);
        }
    });

    //Buscar CEP pelo endereço nos correios
    $("#btnBuscarCEP").click(function (event) {
        event.preventDefault();
        $('.tableResultsCorreios').css('display', 'block');

        var ufBuscaCEP = $('form#formBuscaCEP select[name=ufBuscaCEP]').find('option:selected').text();
        var municipioBuscaCEP = $('form#formBuscaCEP select[name=municipioBuscaCEP]').find('option:selected').text();
        var bairroBuscaCEP = $('form#formBuscaCEP input[name=bairroBuscaCEP]').val();
        var logradouroBuscaCEP = $('form#formBuscaCEP input[name=logradouroBuscaCEP]').val();

        var endereco = logradouroBuscaCEP + ',' + bairroBuscaCEP + ',' + municipioBuscaCEP + ',' + converterEstados(ufBuscaCEP);

        var idDivTabActive = $("ul#tabBarEnderecos li a.active").attr('href');
        self.GetCEPbyEndereco(endereco, idDivTabActive);

    });

    /* Validação */
    self.cpf[0].addEventListener('blur', function ()
    {
        var cpfGroup =$('#cpfGroup');
        if (!(validaCPF(this.value)))
        {
            cpfGroup.addClass("has-danger");
            self.cpf.addClass("form-control-danger");
        }else
        {
            cpfGroup.removeClass("has-danger");
            self.cpf.addClass("form-control-danger");
            cpfGroup.addClass("has-success");
            self.cpf.addClass("form-control-success");
        }
    });
    self.dataNascimento[0].addEventListener('blur', function ()
    {
        var dataNascimentoGroup = $('#dataNascimentoGroup');
        if(!(validaData(this.value)))
        {
            dataNascimentoGroup.addClass("has-danger");
            self.dataNascimento.addClass("form-control-danger");
        }else {
            dataNascimentoGroup.removeClass("has-danger");
            self.dataNascimento.removeClass("form-control-danger");
            dataNascimentoGroup.addClass("has-success");
            self.dataNascimento.addClass("form-control-success");
        }
    });
    self.dataEmissao[0].addEventListener('blur', function ()
    {
        var dataEmissaoGroup = $('#dataEmissaoGroup');
        if(!(validaData(this.value)))
        {
            dataEmissaoGroup.addClass("has-danger");
            self.dataEmissao.addClass("form-control-danger");
        }else {
            dataEmissaoGroup.removeClass("has-danger");
            self.dataEmissao.removeClass("form-control-danger");
            dataEmissaoGroup.addClass("has-success");
            self.dataEmissao.addClass("form-control-success");
        }
    });


    $("#btnSalvar").click(function (event) {
        event.preventDefault();
        self.incluirPessoa();
    });
};

