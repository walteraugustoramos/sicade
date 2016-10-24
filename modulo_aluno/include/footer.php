    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!--JavaScript JqueryUi necessario para funcionamento do autocomplete
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    -->
    <script src="js/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <!--Script Combobox Cidade e Estados-->
    <script language="JavaScript" type="text/javascript" charset="utf-8">
      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })
    </script>

    <!--Script de inicialização do DataTable list-certificados-->
    <script>
        $(document).ready(function() {
        $('#list-certificados').DataTable( {
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "Mostrar _MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        } );
    } );
    </script>

    <!--Inclusão do style da biblioteca DataTable-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    
    <!--Inclusão da biblioteca DataTable-->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    
    <!--Inclusão da javascript do DataTable-->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    
    <!-- Script para Criar Mascara para campos do formulário-->
    <script type="text/javascript" src="js/cria-mascara.js"></script>
    <!--Inclui os arquivos javascript do bootstrap-validator para validação de formularios-->
    <script src="../bootstrap-validator-master/js/validator.js"></script>
    <!--Java script que contem as funções de funcionamento do autocomplete-->
    <script src="custom.js"></script>
    <!--INICIO RODAPÉ-->
    <div class="container-fluid footer">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <center><p>Sicade - <b>S</b>istema <b>I</b>ntegrado de <b>C</b>adastro de <b>E</b>ventos© 2016 Copyright by Augusto Ramos Design by Caroline Assis. All rights reserved.</p></center>
        </div>
      </div>
    </div><!--FIM container-fluid-->
    <!--FIM RODAPÉ-->
  </body>
</html>