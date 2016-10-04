<!--Inclusão do menu principal da index do site-->
<?php
  include 'include/header.php';
?>
<div class="container-fluid">
	<div class="row">
		<h1 class="text-center">Sistema Integrado de Cadastro de Eventos</h1>
	</div>

	<div class="row">
		<div class="col-md-6 col-md-offset-3 form-group">
			<input type="text" id="busca" class="form-control">
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				
				<div class="col-md-2 col-md-offset-1 form-group">
					<label for="nome">Evento</label>
					<input type="text" id="nome" class="form-control form_evento" readonly>
				</div>

				<div class="col-md-2 form-group">
					<label for="nome">Data</label>
					<input type="text" id="data_inicio" class="form-control form_evento" readonly>
				</div>

				<div class="col-md-2 form-group">
					<label for="nome">Hora</label>
					<input type="text" id="hora_inicio" class="form-control form_evento" readonly>
				</div>

				<div class="col-md-2 form-group">
					<label for="nome">Carga Horaria</label>
					<input type="text" id="carga_horaria" class="form-control form_evento" readonly>
				</div>

				<div class="col-md-2 form-group">
					<button type="button" id="participar" class="btn btn-primary" data-toggle="modal" data-target="#login" style="margin-top: 1.7em;" disabled>Participar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal login -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Faça Login</h4>
      </div>
      <div class="modal-body">
        <form action="controller/login.php" method="post" class="form-signin" data-toggle="validator">
            
            <?php
              if(!empty($_SESSION['msg']['error'])){?>
                <div class="alert alert-danger" role="alert">
                  <center><?=$_SESSION['msg']['error']?>
                  </center>
                </div>
                <?php
                  unset($_SESSION['msg']['error']);
                }
                ?>
            <div class="form-group has-feedback">
              <label for="user_name">Usuario: </label>
              <input type="text" name="user_name" class="form-control" autofocus="true" required="true" placeholder="Username" data-error="Digite seu usuario">
              <span class="glyphicon form-control-feedback"></span>
              <small class="help-block with-errors">Por favor, digite seu usuario.</small>
            </div><!--form-group has-feedback-->

            <div class="form-group has-feedback">
              <label for="password">Senha: </label>
              <input type="password" name="password" class="form-control" required="true" placeholder="Password" data-error="Digite sua senha">
              <span class="glyphicon form-control-feedback"></span>
              <small class="help-block with-errors">Por favor, digite sua senha.</small>
            </div>
          
            <button type="submit" class="btn bnt-lg btn-primary btn-block" style="margin-top:1em;">Fazer login</button>
            <span><a href="#">Esqueceu sua senha ?</a></span>
            <span><a href="#" data-toggle="modal" data-target="#criar_conta" data-dismiss="modal">Criar uma conta</a></span>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Fim modal login-->

<!-- Modal Criar uma conta-->
<div class="modal fade" id="criar_conta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crie sua Conta</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Fim modal Criar uma conta-->

<!--Inclusão do rodapé-->
<?php 
	include 'include/footer.php';
?>