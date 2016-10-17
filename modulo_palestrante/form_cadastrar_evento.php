<!--Inclusão do menu principal do palestrante-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<fieldset>
					<legend><center>Cadastro de Evento</center></legend>
					<input type="hidden" name="action" value="cadastrar_evento" >
					<div class="row">
						<div class="col-md-3 col-md-offset-3 form-group has-feedback">
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
						<div class='col-md-3 col-md-offset-3 form-group has-feedback'>
							<label for="data_inicio">Data Inicio:</label>
				            <div class='input-group date' id='datetimepicker6'>
				                <input type='text' name="data_inicio" class="form-control" required="true" data-error="Preencha este campo."/>
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				                <span class="glyphicon form-control-feedback"></span>
								<small class="with-errors"></small>
				            </div> 
				    	</div>

					    <div class='col-md-3 form-group has-feedback'>
					    	<label for="data_inicio">Data Fim:</label>
				            <div class='input-group date' id='datetimepicker7'>
				                <input type='text' name="data_fim" class="form-control" required="true" data-error="Preencha este campo."/>
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				                <span class="glyphicon form-control-feedback"></span>
								<small class="with-errors"></small>
				            </div>
					    </div>
					    
						<div class="col-md-2 form-group has-feedback">
							<label for="quantidade_vagas">Quantidade Vagas: </label>
							<input type="number" name="quantidade_vagas" min="1" class="form-control" required="true" placeholder="0">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: 40</small>
						</div>
			    	</div><!--row < form-->

					<div class="row">
						<div class="col-md-4 col-md-offset-3 form-group">
						  <label for="descricao">Descrição: </label>
						  <textarea class="form-control" rows="5" name="descricao" id="descricao" required="true" placeholder="Breve descrição sobre o tema do evento." data-error="Preencha este campo."></textarea>
						  <span class="glyphicon form-control-feedback"></span>
						  <small class="help-block with-errors"></small>
						</div>
					</div><!--row < form-->

					<div class="row">
						<div class="col-md-2 col-md-offset-3">
							<button type="submit" class="btn btn-primary">Salvar</button>
							<button type="reset" class="btn btn-default">Limpar</button>
						</div>
					</div><!--row < form-->
				</fieldset>
			</form><!--form < col-md-12-->
		</div><!--col-md-12 < row < container-fluid-->
	</div><!--row < container-fluid-->
</div><!--container-fluid-->

<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>