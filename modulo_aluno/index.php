<!--Inclusão do menu principal do aluno-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/AlunoDAO.class.php';
  include '../controller/EventoDAO.class.php';
  include '../model/UserLogin.class.php';
  include '../PHPMailer/PHPMailerAutoload.php';

  if(!empty($_SESSION['evento']['id_evento'])){
      $alunoDAO = new AlunoDAO();
      $eventoDAO = new EventoDAO();
      $user_login = new UserLogin();

      // gera o numero de inscrição
      $numero_inscricao = $eventoDAO->gerarNumeroInscricao(10,false,true,false);

      $aluno = $alunoDAO->getAluno($_SESSION['user']['id']);

      $id_evento = $_SESSION['evento']['id_evento'];

      // recupera os dados do evento que o aluno está se inscrevendo
      $evento = $eventoDAO->getEvento($id_evento, 1);

      $aluno = $alunoDAO->getAluno($_SESSION['user']['id']);

      $user_login->setNumeroInscricao($numero_inscricao);
      $user_login->setName($aluno['nome']);
      $user_login->setEmail($aluno['email']);

      if($alunoDAO->inscreverAluno($aluno['id_aluno'],$id_evento, $numero_inscricao) && $eventoDAO->setQuantidadeInscritosEvento($id_evento,($evento['quantidade_inscritos']+1)) && $eventoDAO->sendNumeroInscricaoForEmail($user_login,$evento['nome'])){
        $_SESSION['msg']['success'] = 'Inscrição realizada com sucesso.';
        unset($_SESSION['evento']['id_evento']);
      }else{
        $_SESSION['msg']['error'] = 'Desculpe mais você já esta inscrito neste evento.';
        unset($_SESSION['evento']['id_evento']);
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
      <img src="../img/sicade.png" alt="sicade" class="img-responsive" title="sicade">
    </div>
  </div>

  <div class="row" style="margin-top: 2em;">
    <div class="col-md-6 col-md-offset-3 form-group">
      <input type="text" id="busca" class="form-control">
    </div>
  </div>

  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      <div class="row">
        <form action="controller/index.php" method="post">
        <input type="hidden" name="action" value="inscrever_aluno">
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