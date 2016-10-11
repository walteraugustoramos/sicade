<!--Inclusão do menu principal do palestrante-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/EventoDAO.class.php';

  if(empty($_GET['id_evento'])){
  	$_SESSION['msg']['error'] = 'Error ao carregar dados do evento para edição.';
  	header('Location:index.php');
  }else{
  	$eventoDAO = new EventoDAO();

  	$evento_dados = $eventoDAO->getEvento($_GET['id_evento'],1);

  	// conversão de data para o padrão brasileiro
  	$evento_dados['data_inicio'] = implode("/",array_reverse(explode("-",$evento_dados['data_inicio'])));

  	// conversão de data para o padrão brasileiro
  	$evento_dados['data_fim'] = implode("/",array_reverse(explode("-",$evento_dados['data_fim'])));
  }
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<input type="hidden" name="action" value="editar_evento" >
				<input type="hidden" name="id_evento" value="<?=$evento_dados['id_evento']?>" >
				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="name">Nome: </label>
						<input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome do Evento" data-error="Preencha este campo." value="<?=$evento_dados['nome']?>">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors"></small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="carga_horaria">Carga Horaria: </label>
						<input type="number" name="carga_horaria" min="1" class="form-control" required="true" placeholder="0" value="<?=$evento_dados['carga_horaria']?>">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 8</small>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-2 form-group has-feedback">
						<label for="data_inicio">Data Inicio: </label>
						<input type="text" name="data_inicio" class="form-control date_picker" required="true" placeholder="DD/MM/YYYY" data-error="Preencha este campo." onkeyup="criaMascara(this, '##/##/####');" value="<?=$evento_dados['data_inicio']?>">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 09/11/1994</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="hora_inicio">Hora Inicio: </label>
						<input type="text" name="hora_inicio" class="form-control" required="true" placeholder="HH:MM" data-error="Preencha este campo." onkeyup="criaMascara(this, '##:##');" value="<?=$evento_dados['hora_inicio']?>">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 21:00</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="data_fim">Data Fim: </label>
						<input type="text" name="data_fim" class="form-control date_picker" required="true" placeholder="DD/MM/YYYY" data-error="Preencha este campo." onkeyup="criaMascara(this, '##/##/####');" value="<?=$evento_dados['data_fim']?>">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 09/11/1994</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="hora_fim">Hora Fim: </label>
						<input type="text" name="hora_fim" class="form-control" required="true" placeholder="HH:MM" data-error="Preencha este campo." onkeyup="criaMascara(this, '##:##');" value="<?=$evento_dados['hora_fim']?>">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 22:00</small>
					</div>

				</div><!--row < form-->

				<div class="row">
					<div class="col-md-4 form-group">
					  <label for="descricao">Descrição: </label>
					  <textarea class="form-control" rows="5" name="descricao" id="descricao" required="true" placeholder="Breve descrição sobre o tema do evento." data-error="Preencha este campo."><?=$evento_dados['descricao']?></textarea>
					  <span class="glyphicon form-control-feedback"></span>
					  <small class="help-block with-errors"></small>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary">Salvar</button>
						<button type="reset" class="btn btn-default">Limpar</button>
					</div>
				</div><!--row < form-->
			</form><!--form < col-md-12-->
		</div><!--col-md-12 < row < container-fluid-->
	</div><!--row < container-fluid-->
</div><!--container-fluid-->

<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>