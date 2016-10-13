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
    <!-- Script para Criar Mascara para campos do formulário-->
    <script type="text/javascript" src="js/cria-mascara.js"></script>
    <!--Inclui os arquivos javascript do bootstrap-validator para validação de formularios-->
    <script src="../bootstrap-validator-master/js/validator.js"></script>
    <!--Script para validar cpf-->
    <script type="text/javascript" src="js/validar-cpf.js"></script>
  </body>
</html>