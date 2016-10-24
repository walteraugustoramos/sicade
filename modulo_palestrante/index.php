<!--Inclusão do menu principal do palestrante-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/PalestranteDAO.class.php';
  include '../controller/EventoDAO.class.php';
  include '../controller/AlunoDAO.class.php';
  include '../controller/VisitanteDAO.class.php';

  $palestranteDAO = new PalestranteDAO();
  $eventoDAO = new EventoDAO();
  $alunoDAO = new AlunoDAO();
  $visitanteDAO = new VisitanteDAO();

  // retorna um array contendo todos os dados do palestrante que está logado no sistema
  $palestrante = $palestranteDAO->getPalestrante($_SESSION['user']['id']);

  //verifico se existem eventos cadastrados pelo palestrante
  if($palestranteDAO->getPalestrantehasEvento($palestrante['id_palestrante']) != 0){
	  // retorna um array contendo os ids dos eventos cadastrados por o palestrante que está logado no sistema
	  $palestrante_has_evento = $palestranteDAO->getPalestrantehasEvento($palestrante['id_palestrante']);

	  for($i = 0; $i < count($palestrante_has_evento); $i++){
	    // retorna um arrauy contendo todas as informações dos eventos cadastrado pelo palestrante que ainda não aconteceram
	    if($eventoDAO->getEvento($palestrante_has_evento[$i]['evento_id_evento'],1) != 0){
	      $eventos_dados[] = $eventoDAO->getEvento($palestrante_has_evento[$i]['evento_id_evento'],1);
	    }
	  }
?>
<div class="container-fluid">
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-5 col-xs-4 col-xs-offset-4">
      <img src="../img/sicade.png" alt="" class="img-responsive">
    </div>
  </div>
  <div id="list" class="row" style="margin-top: 2em;">
    <div class="table-responsive table-striped table-hover col-md-6 col-md-offset-3">
      <table class="table" id="list-eventos">
        <thead>
          <tr>
            <th>Evento</th>
            <th class="actions">Ação</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            foreach($eventos_dados as $evento){
           ?>
          <tr>
            <td><?=$evento['nome']?></td>
            <td class="actions">
              <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-chamada<?php echo $evento['id_evento']?>">Chamada</a>
              <!--modal chamada-->
                <div class="modal fade" id="modal-chamada<?php echo $evento['id_evento']?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Faça a Chamada</h4>
                      </div>
                      <div class="modal-body">
                        <?php
                          // verifica se existe pelo menos 1 aluno ou visitante inscrito no evento
                          if($alunoDAO->getAllAlunoInscrito($evento['id_evento']) != false || $visitanteDAO->getAllVisitanteInscrito($evento['id_evento']) != false){
                            ?>
                            <form action="controller/index.php" method="post">
                              <input type="hidden" name="action" value="realizar_chamada">
                              <input type="hidden" name="id_palestrante" value="<?=$palestrante['id_palestrante']?>">
                              <input type="hidden" name="id_evento" value="<?=$evento['id_evento']?>">

                              <div class="table-responsive table-striped table-hover">
                                <table class="table" id="list-chamada">
                                  <thead>
                                    <tr>
                                      <th>N° Inscrição</th>
                                      <th>Participante</th>
                                      <th>Status</th>
                                    </tr>
                                  </thead>

                                  <tbody>
                                    <?php
                                    // verifico se existe aluno inscrito no evento
                                    if($alunoDAO->getAllAlunoInscrito($evento['id_evento']) != false){
                                      $alunos_inscritos = $alunoDAO->getAllAlunoInscrito($evento['id_evento']);

                                      echo "<input type='hidden' name='verifica_aluno' value='1'>";
                                      for($a = 0; $a < count($alunos_inscritos); $a++){
                                        $aluno = $alunoDAO->getAlunohasEventoById($alunos_inscritos[$a]['id_aluno']);
                                     ?>
                                      <tr>
                                        <td><?echo $aluno['numero_inscricao']?></td>
                                        <td><?echo $alunos_inscritos[$a]['nome']?></td>
                                        <input type="hidden" name="id_aluno[]" value="<?=$alunos_inscritos[$a]['id_aluno']?>">
                                        <td>
                                          <div class="col-md-5">
                                            <select name="presente[]" id="presente" class="form-control">
                                              <option value="1" selected="true">Presente</option>
                                              <option value="0">Ausente</option>
                                            </select>
                                          </div>  
                                        </td>
                                      </tr>
                                     <?php
                                      }// fechamento do for($i = 0; $i < count($alunos_inscritos); $i++)
                                    }// fechamento do if($alunoDAO->getAllAlunoInscrito($evento['id_evento']) != false)
                                      ?>
                                    <?php 
                                      // verifico se existe visitante inscrito no evento
                                    if($visitanteDAO->getAllVisitanteInscrito($evento['id_evento'])){
                                      $visitantes_inscritos = $visitanteDAO->getAllVisitanteInscrito($evento['id_evento']);
                                      echo "<input type='hidden' name='verifica_visitante' value='1'>";
                                      for($v = 0; $v < count($visitantes_inscritos); $v++){
                                        $visitante = $visitanteDAO->getVisitantehasEventoById($visitantes_inscritos[$v]['id_visitante']);
                                     ?>
                                      <tr>
                                        <td><?echo $visitante['numero_inscricao']?></td>
                                        <td><?echo $visitantes_inscritos[$v]['nome'];?></td>
                                        <input type="hidden" name="id_visitante[]" value="<?=$visitantes_inscritos[$v]['id_visitante']?>">
                                        <td>
                                          <div class="col-md-5">
                                            <select name="presente[]" id="presente" class="form-control">
                                              <option value="1" selected="true">Presente</option>
                                              <option value="0">Ausente</option>
                                            </select>
                                          </div>  
                                        </td>
                                      </tr>
                                     <?php
                                      }// fechamento do for($v = 0; $v < count($visitantes_inscritos); $v++)
                                    }// fechamento do if($visitanteDAO->getAllVisitanteInscrito($evento['id_evento']))                                     
                                      ?>
                                  </tbody>
                                </table>
                              </div>
                              <button type="submit" class="btn btn-primary">Realizar Chamada</button>
                            </form>
                        <?php
                          }else{
                            echo "<span class='alert-danger'>Ainda não há nenhum participante inscrito neste evento.</span>";
                          }
                        ?>
                      </div><!--modal-body-->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div><!--fim modal chamada-->
              <a href="form_editar_evento.php?id_evento=<?=$evento['id_evento']?>" class="btn btn-warning btn-xs">Editar</a>
            </td>
          </tr>
          <?php 
            }// fechamento foreach($eventos_dados as $evento)
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php 
	}else{?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 col-md-offset-5">
				<center><span class="alert alert-warning" role="alert">Cadastre um evento para palestrar.</span></center>
			</div>
		</div>
	</div>
	<?php
	}// fechamento do else
 ?>
   <div class="row" style="margin-top: 2em;">
    <div class="col-md-3 col-md-offset-5">
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
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>