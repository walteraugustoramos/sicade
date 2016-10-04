<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<input type="hidden" name="action" value="cadastrar_evento" >
				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="name">Nome: </label>
						<input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome do Evento" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors"></small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="carga_horaria">Carga Horaria: </label>
						<input type="number" name="carga_horaria" min="1" class="form-control" required="true" placeholder="0">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 8</small>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-2 form-group has-feedback">
						<label for="data_inicio">Data Inicio: </label>
						<input type="text" name="data_inicio" class="form-control date_picker" required="true" placeholder="DD/MM/YYYY" data-error="Preencha este campo." onkeyup="criaMascara(this, '##/##/####');">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 09/11/1994</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="hora_inicio">Hora Inicio: </label>
						<input type="text" name="hora_inicio" class="form-control" required="true" placeholder="HH:MM" data-error="Preencha este campo." onkeyup="criaMascara(this, '##:##');">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 21:00</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="data_fim">Data Fim: </label>
						<input type="text" name="data_fim" class="form-control date_picker" required="true" placeholder="DD/MM/YYYY" data-error="Preencha este campo." onkeyup="criaMascara(this, '##/##/####');">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 09/11/1994</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="hora_fim">Hora Fim: </label>
						<input type="text" name="hora_fim" class="form-control" required="true" placeholder="HH:MM" data-error="Preencha este campo." onkeyup="criaMascara(this, '##:##');">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 22:00</small>
					</div>

				</div><!--row < form-->

				<div class="row">
					<div class="col-md-4 form-group">
					  <label for="descricao">Descrição: </label>
					  <textarea class="form-control" rows="5" name="descricao" id="descricao" required="true" placeholder="Breve descrição sobre o tema do evento." data-error="Preencha este campo."></textarea>
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