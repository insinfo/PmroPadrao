/******* FUNÇÕES UTILITARIOS ********/
//Impede digitação de letras no input
function preventsLetter(dom)
{
    $(dom).on('keydown', function (evt) {
        //evt = evt || window.event;
        var keyCode = evt.which;//(evt.keyCode ? evt.keyCode :evt.which);
        if (!(keyCode > 95 && keyCode < 106 || keyCode == 8 || keyCode == 46 || keyCode == 38))
        {
            evt.preventDefault();
        }
    });
}

//Impede digitação de numeros no input
function preventsNumber(dom)
{
    $(dom).on('keydown', function (evt) {
        var keyCode = (evt.keyCode ? evt.keyCode : evt.which);
        if ((keyCode > 95 ))
        {
            evt.preventDefault();
        }
    });
}

//Detecta se digitou numero no input
function detectaNumero(dom, callBack)
{
    dom.on('input', function (e) {
        if (/[0-9]/g.test(this.value))
        {
            callBack();
        }
    });
}

//prenche os selects
function populateSelect(jquerySelect, data, key, value, selected)
{
    jquerySelect.empty();
    for (var j = 0; j < data.length; j++)
    {
        var id = data[j][key];
        var name = data[j][value];
        var option = '<option value="' + id + '">' + smartCapitalize(name) + '</option>';
        if (name.toLowerCase() == selected.toLowerCase())
        {
            option = '<option value="' + id + '" selected>' + smartCapitalize(name) + '</option>';
        }
        jquerySelect.append(option);
    }
}

//Coloca maiuscula a primeira letra com pronome
function capitalize(str)
{
    str.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function (letter) {
        return letter.toUpperCase();
    });
    return (str);
}

//Coloca maiuscula a primeira letra sem pronome
function smartCapitalize(text)
{
    var loweredText = text.toLowerCase();
    var words = loweredText.split(" ");
    for (var a = 0; a < words.length; a++)
    {
        var w = words[a];

        var firstLetter = w[0];

        if (w.length > 2)
        {
            w = firstLetter.toUpperCase() + w.slice(1);
        }
        else
        {
            w = firstLetter + w.slice(1);
        }

        words[a] = w;
    }
    return words.join(" ");
}

function converterEstados(val)
{
    var data;

    switch (val)
    {
        /* UFs */
        case "AC" :
            data = "Acre";
            break;
        case "AL" :
            data = "Alagoas";
            break;
        case "AM" :
            data = "Amazonas";
            break;
        case "AP" :
            data = "Amapá";
            break;
        case "BA" :
            data = "Bahia";
            break;
        case "CE" :
            data = "Ceará";
            break;
        case "DF" :
            data = "Distrito Federal";
            break;
        case "ES" :
            data = "Espírito Santo";
            break;
        case "GO" :
            data = "Goiás";
            break;
        case "MA" :
            data = "Maranhão";
            break;
        case "MG" :
            data = "Minas Gerais";
            break;
        case "MS" :
            data = "Mato Grosso do Sul";
            break;
        case "MT" :
            data = "Mato Grosso";
            break;
        case "PA" :
            data = "Pará";
            break;
        case "PB" :
            data = "Paraíba";
            break;
        case "PE" :
            data = "Pernambuco";
            break;
        case "PI" :
            data = "Piauí";
            break;
        case "PR" :
            data = "Paraná";
            break;
        case "RJ" :
            data = "Rio de Janeiro";
            break;
        case "RN" :
            data = "Rio Grande do Norte";
            break;
        case "RO" :
            data = "Rondônia";
            break;
        case "RR" :
            data = "Roraima";
            break;
        case "RS" :
            data = "Rio Grande do Sul";
            break;
        case "SC" :
            data = "Santa Catarina";
            break;
        case "SE" :
            data = "Sergipe";
            break;
        case "SP" :
            data = "São Paulo";
            break;
        case "TO" :
            data = "Tocantíns";
            break;

        /* Estados */
        case "Acre" :
            data = "AC";
            break;
        case "Alagoas" :
            data = "AL";
            break;
        case "Amazonas" :
            data = "AM";
            break;
        case "Amapá" :
            data = "AP";
            break;
        case "Bahia" :
            data = "BA";
            break;
        case "Ceará" :
            data = "CE";
            break;
        case "Distrito Federal" :
            data = "DF";
            break;
        case "Espírito Santo" :
            data = "ES";
            break;
        case "Goiás" :
            data = "GO";
            break;
        case "Maranhão" :
            data = "MA";
            break;
        case "Minas Gerais" :
            data = "MG";
            break;
        case "Mato Grosso do Sul" :
            data = "MS";
            break;
        case "Mato Grosso" :
            data = "MT";
            break;
        case "Pará" :
            data = "PA";
            break;
        case "Paraíba" :
            data = "PB";
            break;
        case "Pernambuco" :
            data = "PE";
            break;
        case "Piauí" :
            data = "PI";
            break;
        case "Paraná" :
            data = "PR";
            break;
        case "Rio de Janeiro" :
            data = "RJ";
            break;
        case "Rio Grande do Norte" :
            data = "RN";
            break;
        case "Rondônia" :
            data = "RO";
            break;
        case "Roraima" :
            data = "RR";
            break;
        case "Rio Grande do Sul" :
            data = "RS";
            break;
        case "Santa Catarina" :
            data = "SC";
            break;
        case "Sergipe" :
            data = "SE";
            break;
        case "São Paulo" :
            data = "SP";
            break;
        case "Tocantíns" :
            data = "TO";
            break;
    }

    return data;
};

//dispara evento
function eventFire(el, etype)
{
    if (el.fireEvent)
    {
        el.fireEvent('on' + etype);
    }
    else
    {
        var evObj = document.createEvent('Events');
        evObj.initEvent(etype, true, false);
        el.dispatchEvent(evObj);
    }
}

//limpa a seleção de um Select
function clearSelected(dom)
{
    var elements = dom.options;

    for (var i = 0; i < elements.length; i++)
    {
        elements[i].selected = false;
    }
}

/************* VALIDAÇÃO DE FORMULARIO *************/
//Validação
function validaCPF(numCpf)
{
    //remove a mascara
    var cpf = numCpf.replace(/[^\d]+/g,'');
    //Verifica se um número foi informado
    if (!cpf)
    {
        return false;
    }

    //Eliminapossivel mascara
    cpf.replace('[^0-9]', '');
    cpf.lpad('0', 11);
    //Verifica se o numero de digitos informados é iguala 11
    if (cpf.length != 11)
    {
        return false;
    }
    //Verifica se nenhuma das sequências invalidas abaixo
    //foi digitada+Caso afirmativo,retorna falso
    if (cpf == '00000000000' || cpf == '11111111111' || cpf == '22222222222' || cpf == '33333333333' || cpf == '44444444444' || cpf == '55555555555' || cpf == '66666666666' || cpf == '77777777777' || cpf == '88888888888' || cpf == '99999999999')
    {
        return false;
    }
    // Calcula os digitos verificadores para verificar se o
    // CPF é válido
    else
    {
        for (var t = 9; t < 11; t++)
        {
            for (var d = 0, c = 0; c < t; c++)
            {
                d += cpf[c] * ((t + 1) - c);
            }
            d = ((10 * d) % 11) % 10;
            if (cpf[c] != d)
            {
                return false;
            }
        }
        return true;
    }
}
function validaEmail(email)
{
    var nomeEmail = email.value.substring(0, email.value.indexOf("@"));
    var dominioEmail = email.value.substring(email.value.indexOf("@") + 1, email.value.length);

    if ((nomeEmail.length >= 1) && (dominioEmail.length >= 3) && (nomeEmail.search("@") == -1) && (dominioEmail.search("@") == -1) && (nomeEmail.search(" ") == -1) && (dominioEmail.search(" ") == -1) && (dominioEmail.search(".") != -1) && (dominioEmail.indexOf(".") >= 1) && (dominioEmail.lastIndexOf(".") < dominioEmail.length - 1))
    {
        //alert("E-mail valido");
    }
    else
    {
        alert("E-mail invalido");
    }
}
function isEmail(email)
{
    er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;

    if (er.exec(email))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function validaData(data)
{
    if (data.length == 10)
    {
        var er = /(0[0-9]|[12][0-9]|3[01])[-\.\/](0[0-9]|1[012])[-\.\/][0-9]{4}/;

        if (er.exec(data))
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    else
    {
        return false;
    }
}
function validaHora(hora)
{
    var er = /(0[0-9]|1[0-9]|2[0123]):[0-5][0-9]/;

    if (er.exec(hora))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//faz um LEFT PAD de uma string
String.prototype.lpad = function (padString, length) {
    var str = this;
    while (str.length < length) str = padString + str;
    return str;
};