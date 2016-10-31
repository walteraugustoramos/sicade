<?php 
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/PalestranteDAO.class.php';
  include '../controller/EventoDAO.class.php';
  include '../controller/AlunoDAO.class.php';
  include '../controller/VisitanteDAO.class.php';

  $alunoDAO = new AlunoDAO();
  $visitanteDAO = new VisitanteDAO();
  $eventoDAO = new EventoDAO();
  $palestranteDAO = new PalestranteDAO();

  if(empty($_GET['id_evento'])){
  	header('Location:index.php');
  }

  // verifica se existe pelo menos 1 aluno ou 1 visitante inscrito no evento
  if($alunoDAO->getAllAlunoInscrito($_GET['id_evento']) != false || $visitanteDAO->getAllVisitanteInscrito($_GET['id_evento']) != false){
  	$id_evento = $_GET['id_evento'];

  	// retorna os dados do palestrante que palestra o evento
  	$palestrante = $palestranteDAO->getPalestranteByIdEvento($id_evento);
  	
  	$id_palestrante = $palestrante['palestrante_id_palestrante'];
 ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 col-md-offset-4">
			<center><h3>Chamada</h3></center>
		</div>
	</div>
	<form action="controller/index.php" method="post">
		<input type="hidden" name="action" value="realizar_chamada">
		<input type="hidden" name="id_palestrante" value="<?=$id_palestrante?>">
		<input type="hidden" name="id_evento" value="<?=$id_evento?>">

		<div class="table-responsive table-striped table-hover col-md-8 col-md-offset-2">
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
						//verifico se existe pelo menos 1 aluno inscrito no evento
						if($alunoDAO->getAllAlunoInscrito($id_evento) != false){
							$alunos_inscritos = $alunoDAO->getAllAlunoInscrito($id_evento);
							$quantidade_alunos = 0;

							for($a = 0; $a < count($alunos_inscritos); $a++){
								$aluno = $alunoDAO->getAlunohasEventoById($alunos_inscritos[$a]['id_aluno']);
								$quantidade_alunos = $quantidade_alunos + 1;
					 ?>
					 <tr>
					 	<td><?echo $aluno['numero_inscricao']?></td>
					 	<td><?echo $alunos_inscritos[$a]['nome']?></td>
					 	<input type="hidden" name="id_aluno[]" value="<?=$alunos_inscritos[$a]['id_aluno']?>">
                        <input type="hidden" name="quantidade_alunos" value="<?=$quantidade_alunos?>">
                        <td>
                        	<div class="col-md-6">
		                        <select name="presenca_aluno[]" id="presenca_aluno" class="form-control">
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
					 	// verifico se existe pelo menos 1 visitante inscrito no evento
					 	if($visitanteDAO->getAllVisitanteInscrito($id_evento) != false){
					 		$visitantes_inscritos = $visitanteDAO->getAllVisitanteInscrito($id_evento);
					 		$quantidade_visitantes = count($visitantes_inscritos);

					 		for($v = 0; $v < count($visitantes_inscritos); $v++){
					 			$visitante = $visitanteDAO->getVisitantehasEventoById($visitantes_inscritos[$v]['id_visitante']);
					  ?>
					  <tr>
					  	<td><?echo $visitante['numero_inscricao']?></td>
					  	<td><?echo $visitantes_inscritos[$v]['nome']?></td>
                        <input type="hidden" name="id_visitante[]" value="<?=$visitantes_inscritos[$v]['id_visitante']?>">
                        <input type="hidden" name="quantidade_visitantes" value="<?=$quantidade_visitantes?>">
                        <td>
                          <div class="col-md-6">
                            <select name="presenca_visitante[]" id="presenca_visitante" class="form-control">
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

		<div class="row">
			<div class="col-md-4 col-md-offset-5">
				<button type="submit" class="btn btn-primary">Realizar Chamada</button>
				<a href="index.php" class="btn btn-default">Voltar</a>
			</div>
		</div>

	</form>
	<?php 
		}else{
			echo "<center><span class='alert-danger'>Ainda não há nenhum participante inscrito neste evento.</span></center>";
		}
	 ?>
</div>

 <?php 
  include 'include/footer.php';
 ?>