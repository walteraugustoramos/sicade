<!--Inclusão do menu principal do visitante-->
<?php
  include 'include/header.php';
  include '../include/config.php';

  $PDO = connection();

  try{
  	// inicia a transação
	$PDO->beginTransaction();
	
	$sql = "SELECT *FROM visitante WHERE users_id_user = :user_id";

	$statement = $PDO->prepare($sql);

	$statement->bindValue(':user_id',$_SESSION['user']['id']);

	$statement->execute();

	if($statement->rowCount() != 0){
		while($visitante_dados = $statement->fetch(pdo::FETCH_ASSOC)){
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form action="controller/index.php" method="post" data-toggle="validator">
				<fieldset>
					<legend><center>Alterar Meus Dados</center></legend>
					<input type="hidden" name="action" value="editar_visitante" >
					<input type="hidden" name="id_visitante" value="<?=$visitante_dados['id_visitante']?>">
					<div class="row">
						<div class="col-md-3 col-md-offset-3 form-group has-feedback">
							<label for="name">Nome: </label>
							<input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo." value="<?=$visitante_dados['nome']?>">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: Jon Snow</small>
						</div>

						<div class="col-md-2 form-group">
							<label for="cpf">Cpf: </label>
							<input type="text" name="cpf" id="cpf" class="form-control" required="true" onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14" value="<?=$visitante_dados['cpf']?>" disabled>
						</div>
					</div><!--row < form-->

					<div class="row">
						<div class="col-md-3 col-md-offset-3 form-group has-feedback">
							<label for="email">E-mail: </label>
							<input type="email" name="email" class="form-control" required="true" placeholder="Seu melhor email" data-error="Preencha este campo." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?=$visitante_dados['email']?>">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: jonsnow@westeros.com</small>
						</div>

						<div class="col-md-2 form-group has-feedback">
							<label for="celular">Celular: </label>
							<input type="tel" name="celular" class="form-control" required="true" placeholder="Somente numeros" pattern=".{14,14}" data-error="Preencha este campo." onkeyup="criaMascara(this, '(##)#####-####');" value="<?=$visitante_dados['celular']?>">
							<span class="glyphicon form-control-feedback"></span>
							<small class="help-block with-errors">Ex: (33)988850155</small>
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
	<?php  
		}// fechamento laço while
			}else{
				$PDO->rollBack();
			}// fechamento do else

		  }catch(pdoexception $e){
		  	echo 'Falha ao listar dados do visitante: '.$e->getMessage();
		  	$PDO->rollBack();
		  }
  	?>
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>