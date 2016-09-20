<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="#">
				<div class="row">
					<div class="col-md-3">
						<label for="name">Nome: </label>
						<input type="text" name="name" class="form-control">
					</div>

					<div class="col-md-2">
						<label for="cpf">Cpf: </label>
						<input type="text" name="cpf" class="form-control">
					</div>

					<div class="col-md-3">
						<label for="email">E-mail: </label>
						<input type="email" name="email" class="form-control">
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-3">
						<label for="endereco">Endereço: </label>
						<input type="text" name="endereco" class="form-control">
					</div>

					<div class="col-md-2">
						<label for="bairro">Bairro: </label>
						<input type="text" name="bairro" class="form-control">
					</div>

					<div class="col-md-1">
						<label for="numero">N°</label>
						<input type="number" name="numero" class="form-control">
					</div>

					<div class="col-md-2">
						<label for="celular">Celular: </label>
						<input type="text" name="celular" class="form-control">
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-2">
						<label for="estado">Estado: </label>
						<select name="estado" id="estado" class="form-control">
							<option value="">Minas Gerais</option>
						</select>
					</div>

					<div class="col-md-3">
						<label for="cidade">Cidade: </label>
						<select name="cidade" id="cidade" class="form-control">
							<option value="">Ouro Verde de Minas</option>
							<option value="">Frei Gaspar</option>
						</select>
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-3">
						<label for="user_name">Usuário: </label>
						<input type="text" name="user_name" class="form-control">
					</div>

					<div class="col-md-2">
						<label for="password">Senha: </label>
						<input type="password" name="password" class="form-control">
					</div>
				</div><!--row < form-->

				<div class="row">
					<div class="col-md-2" style="margin-top:0.5em;">
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