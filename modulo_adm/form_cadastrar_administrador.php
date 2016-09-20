<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post" data-toggle="validator">
				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="name">Nome: </label>
						<input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: Jon Snow</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="cpf">Cpf: </label>
						<input type="text" name="cpf" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 123.456.789-81</small>
					</div>

					<div class="col-md-3 form-group has-feedback">
						<label for="email">E-mail: </label>
						<input type="email" name="email" class="form-control" required="true" placeholder="Seu melhor email" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: jonsnow@westeros.com</small>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="endereco">Endereço: </label>
						<input type="text" name="endereco" class="form-control" required="true" placeholder="Onde você mora?" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: Winterfell</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="bairro">Bairro: </label>
						<input type="text" name="bairro" class="form-control" required="true" placeholder="Qual bairro?" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: Centro</small>
					</div>

					<div class="col-md-1 form-group has-feedback">
						<label for="numero">N°</label>
						<input type="number" name="numero" class="form-control" required="true" placeholder="0">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: 42</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="celular">Celular: </label>
						<input type="text" name="celular" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: (33)988850155</small>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="estado">Estado: </label>
						<select name="estado" id="estado" class="form-control" required="true" data-error="Selecione um estado."></select>
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: Minas Gerais</small>
					</div>

					<div class="col-md-3 form-group has-feedback">
						<label for="cidade">Cidade: </label>
						<select name="cidade" id="cidade" class="form-control" required="true" data-error="Selecione uma cidade."></select>
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: Ouro Verde de Minas</small>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-3 form-group has-feedback">
						<label for="user_name">Usuário: </label>
						<input type="text" name="user_name" class="form-control" required="true" data-error="Preencha este campo.">
						<span class="glyphicon form-control-feedback"></span>
						<small class="help-block with-errors">Ex: joaodasneves2016</small>
					</div>

					<div class="col-md-2 form-group has-feedback">
						<label for="password">Senha: </label>
						<input type="password" name="password" class="form-control" required="true" data-error="Preencha este campo.">
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