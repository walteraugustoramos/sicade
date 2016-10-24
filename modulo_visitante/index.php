<!--Inclusão do menu principal do visitante-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/VisitanteDAO.class.php';
  include '../controller/EventoDAO.class.php';

  if(!empty($_SESSION['evento']['id_evento'])){

    $visitanteDAO = new VisitanteDAO();
    $eventoDAO = new EventoDAO();

    $id_evento = $_SESSION['evento']['id_evento'];

    $evento = $eventoDAO->getEvento($id_evento, 1);

    $visitante = $visitanteDAO->getVisitante($_SESSION['user']['id']);

    
    if($visitanteDAO->inscreverVisitante($visitante['id_visitante'],$id_evento) && $eventoDAO->setQuantidadeInscritosEvento($id_evento,($evento['quantidade_inscritos']+1))){
      $_SESSION['msg']['success'] = 'Inscrição realizada com sucesso.';
    }     
  }
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
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-5 col-xs-4 col-xs-offset-4">
      <img src="../img/sicade.png" alt="Sicade" class="img-responsive" title="Sicade">
    </div>
  </div>  

  <div class="row" style="margin-top: 1em;">
    <div class="col-md-6 col-md-offset-3 form-group">
      <input type="text" id="busca" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      <div class="row">
        <form action="controller/index.php" method="post">
        <input type="hidden" name="action" value="inscrever_visitante">
        <input type="hidden" name="id_evento" id="id_evento">
        <input type="hidden" name="quantidade_inscritos" id="quantidade_inscritos">
        <div class="col-md-3 form-group">
          <label for="nome">Evento</label>
          <input type="text" name="nome" id="nome" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-3 form-group">
          <label for="nome">Data</label>
          <input type="text" name="data_inicio" id="data_inicio" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-2 form-group">
          <label for="nome">Carga Horaria</label>
          <input type="text" name="carga_horaria" id="carga_horaria" class="form-control form_evento" readonly required="true">
        </div>

        <div class="col-md-2 form-group">
          <label for="nome">Quantidade Vagas</label>
          <input type="text" name="quantidade_vagas" id="quantidade_vagas" class="form-control form_evento" readonly required="true">
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