<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<input type="hidden" name="action" value="cadastrar_curso" >
				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="nome_curso">Curso: </label>
						<input type="text" name="nome_curso" class="form-control" autofocus="true" required="true" placeholder="Nome do Curso" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: Sistemas de Informação</small>
					</div>
				</div>

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