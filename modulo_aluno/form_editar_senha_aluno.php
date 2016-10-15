<!--Inclusão do menu principal do aluno-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<fieldset>
					<legend><center>Alterar Senha</center></legend>
					<input type="hidden" name="action" value="editar_senha_aluno" >
					<div class="row">
						<div class="col-md-2 col-md-offset-4 form-group has-feedback">
							<label for="password">Nova senha: </label>
							<input type="password" id="password" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors"></small>
						</div>

						<div class="col-md-2 form-group has-feedback">
							<label for="repeat-password">Repetir nova senha: </label>
							<input type="password" id="repeat-password" name="repeat-password" data-match="#password" class="form-control" required="true" data-error="Senhas devem ser iguais.">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors"></small>
						</div>
					</div><!--row < form-->

					<div class="row">
						<div class="col-md-2 col-md-offset-4">
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