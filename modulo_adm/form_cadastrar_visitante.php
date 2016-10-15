<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-11 col-md-offset-1">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<fieldset>
					<legend><center>Cadastro de Visitante</center></legend>
					<input type="hidden" name="action" value="cadastrar_visitante" >
					<div class="row">
						<div class="col-md-3 col-md-offset-3 form-group has-feedback">
							<label for="name">Nome: </label>
							<input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: Jon Snow</small>
						</div>

						<div class="col-md-2 form-group">
							<label for="cpf">Cpf: </label>
							<input type="text" name="cpf" id="cpf" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onblur="javascript: validarCPF(this);" onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14">
							<span id="cpf-invalido" style="background-color: #F2DEDE; color: #A94442;"></span>
							<span id="cpf-valido" style="background-color: #D9EDF7; color: #31708F;"></span>
							<small class="help-block with-errors">Ex: 123.456.789-81</small>
						</div>
					</div><!--row < form-->

					<div class="row">
						<div class="col-md-3 col-md-offset-3 form-group has-feedback">
							<label for="email">E-mail: </label>
							<input type="email" name="email" class="form-control" required="true" placeholder="Seu melhor email" data-error="Preencha este campo." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: jonsnow@westeros.com</small>
						</div>

						<div class="col-md-2 form-group has-feedback">
							<label for="celular">Celular: </label>
							<input type="tel" name="celular" class="form-control" required="true" placeholder="Somente numeros" pattern=".{14,14}" data-error="Preencha este campo." onkeyup="criaMascara(this, '(##)#####-####');">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: (33)988850155</small>
						</div>
					</div><!--row < form-->

					<div class="row">
						<div class="col-md-3 col-md-offset-3 form-group has-feedback">
							<label for="user_name">Usuário: </label>
							<input type="text" name="user_name" class="form-control" required="true" data-error="Preencha este campo.">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: joaodasneves2016</small>
						</div>

						<div class="col-md-2 form-group has-feedback">
							<label for="password">Senha: </label>
							<input type="password" id="password" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors"></small>
						</div>

						<div class="col-md-2 form-group has-feedback">
							<label for="repeat-password">Repetir senha: </label>
							<input type="password" id="repeat-password" name="repeat-password" data-match="#password" class="form-control" required="true" data-error="Senhas devem ser iguais.">
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