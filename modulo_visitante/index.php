<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<?php
              if(!empty($_SESSION['msg']['success'])){?>
                <div class="alert alert-success" role="alert">
                  <center><?=$_SESSION['msg']['success']?>
                  </center>
                </div>
                <?php
                  unset($_SESSION['msg']['success']);
                }
            ?>
			<?php
              if(!empty($_SESSION['msg']['error'])){?>
                <div class="alert alert-danger" role="alert">
                  <center><?=$_SESSION['msg']['error']?>
                  </center>
                </div>
                <?php
                  unset($_SESSION['msg']['error']);
                }
            ?>
		</div>
	</div>
</div>

<div class="container-fluid">
  <div class="row">
    <h1 class="text-center">Sistema Integrado de Cadastro de Eventos</h1>
  </div>

  <div class="row">
    <div class="col-md-6 col-md-offset-3 form-group">
      <input type="text" id="busca" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <form action="controller/index.php" method="post">
        <input type="hidden" name="action" value="inscrever_visitante">
        <input type="hidden" name="id_evento" id="id_evento">
        <div class="col-md-2 col-md-offset-1 form-group">
          <label for="nome">Evento</label>
          <input type="text" name="nome" id="nome" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-2 form-group">
          <label for="nome">Data</label>
          <input type="text" name="data_inicio" id="data_inicio" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-2 form-group">
          <label for="nome">Hora</label>
          <input type="text" name="hora_inicio" id="hora_inicio" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-2 form-group">
          <label for="nome">Carga Horaria</label>
          <input type="text" name="carga_horaria" id="carga_horaria" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-2 form-group">
          <button type="submit" id="participar" class="btn btn-primary" style="margin-top: 1.7em;" disabled>Participar</button>
        </div>
        </form>
      </div><!--row-->
    </div><!--col-md-12-->
  </div>
</div>
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>