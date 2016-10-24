<!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!--JavaScript JqueryUi necessario para funcionamento do autocomplete
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    -->
    <script src="js/jquery-ui.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <!--Script Combobox Cidade e Estados-->
    <script language="JavaScript" type="text/javascript" charset="utf-8">
      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })
    </script>

    <script language="JavaScript" type="text/javascript" charset="utf-8">
      new dgCidadesEstados({
        cidade: document.getElementById('cidade1'),
        estado: document.getElementById('estado1')
      })
    </script>
    <!-- Script para Criar Mascara para campos do formulário-->
    <script type="text/javascript" src="js/cria-mascara.js"></script>
    <!--Inclui os arquivos javascript do bootstrap-validator para validação de formularios-->
    <script src="bootstrap-validator-master/js/validator.js"></script>

    <!--Java script que contem as funções de funcionamento do autocomplete-->
    <script src="custom.js"></script>
    <!--Script para validar cpf-->
    <script type="text/javascript" src="js/validar-cpf.js"></script>
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