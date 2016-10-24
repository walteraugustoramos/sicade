    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <!--Script Combobox Cidade e Estados-->
    <script language="JavaScript" type="text/javascript" charset="utf-8">
      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })
    </script>

    <script type="text/javascript">
        $(function () {
            var dateToday = new Date();//pega a data atual
            $('#datetimepicker6').datetimepicker({ 
                minDate: dateToday,
                format: 'DD/MM/YYYY HH:mm:ss'
             });
            $('#datetimepicker7').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                minDate: dateToday,
                format: 'DD/MM/YYYY HH:mm:ss'
            });
            $("#datetimepicker6").on("dp.change", function (e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function (e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>
    
    <!--Script de inicialização do DataTable list-eventos-->
    <script>
        $(document).ready(function() {
        $('#list-eventos').DataTable( {
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

    <!--Script de inicialização do DataTable list-chamada-->
    <script>
        $(document).ready(function() {
        $('#list-chamada').DataTable( {
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