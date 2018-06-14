window.onload = function () {
    $(document).ready(function () {
        $('select').material_select();
        var cadastraPessoaViewModel = new CadastraPessoaViewModel()
        cadastraPessoaViewModel.init();
    });
};

function CadastraPessoaViewModel()
{
    this.webserviceBaseURL = 'http://pmropadrao.lib.com/';
    this.tableUsuarios = $('#tableUsuarios');
    this.usuariosDataTable = null;
}

CadastraPessoaViewModel.prototype.init = function () {

    this.getUsuarios();
};
CadastraPessoaViewModel.prototype.getUsuarios = function () {
    var self = this;

    if (self.usuariosDataTable != null)
    {
        self.usuariosDataTable.destroy();
    }

    self.usuariosDataTable = self.tableUsuarios.DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
        "ajax": {
            "url": self.webserviceBaseURL + "usuarios",
            "type": "POST"
        },
        "columns":
            [{"data": "nome"},
            {"data": "login"}],
        "searching": true,
        "ordering": false,
        "info": true,
        "language": {
            url:'http://www.riodasostras.rj.gov.br/dev/datatables/Portuguese-Brasil.json'
        }
    });

};