<!--Inclusão do menu principal do aluno-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/AlunoDAO.class.php';
  include '../controller/EventoDAO.class.php';

  $eventoDAO = new EventoDAO();
  $alunoDAO = new AlunoDAO();

  // retorna um array contendo os dados do aluno que está logado no sistema
  $aluno = $alunoDAO->getAluno($_SESSION['user']['id']);

  if($alunoDAO->getEventoAluno($aluno['id_aluno'], 1) != 0){
    // retorna um array contendo os ids dos eventos que o aluno está presente
    $eventos_ids = $alunoDAO->getEventoAluno($aluno['id_aluno'], 1);
  }

  for($i = 0; $i < count($eventos_ids); $i++){
    if($eventoDAO->getEvento($eventos_ids[$i]['evento_id_evento'],0) != 0){
      // retorna um array contendo todas as informações dos eventos que o aluno participou
      $eventos_dados[] = $eventoDAO->getEvento($eventos_ids[$i]['evento_id_evento'],0);
    }
  }
  echo "<pre>";
  var_dump($eventos_dados);
  echo "</pre>";
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
  <div id="list" class="row">
    <div class="table-responsive table-hover table-striped col-md-6 col-md-offset-3">
      <table class="table" id="list-certificados">
        <thead>
          <tr>
            <th>Evento</th>
            <th>Carga Horaria</th>
            <th class="actions">Ação</th>
          </tr>
        </thead>

        <tbody>
          <form action="controller/index.php" method="post">
          <input type="hidden" name="action" value="gerar_certificado">
          <input type="hidden" name="id_aluno" value="<?=$aluno['id_aluno']?>">
          <?php 
            foreach($eventos_dados as $evento){
           ?>
          <tr>
            <input type="hidden" name="id_evento" value="<?=$evento['id_evento']?>">
            <td><?php echo $evento['nome']?></td>
            <td><?php echo $evento['carga_horaria']?></td>
            <td><button type="submit" class="btn btn-primary btn-xs">Gerar</button></td>
          </tr>
          <?php 
            }// fechamento do foreach($eventos_dados as $evento)
           ?>
          </form>
        </tbody>
      </table>
    </div>
  </div>
</div><!--container-fluid-->
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>