<!--Inclusão do menu principal da index do site-->
<?php
  include 'include/header.php';

  // cria variavel de sessão com o id do evento
  if(!empty($_POST['id_evento'])){
  	$_SESSION['evento']['id_evento'] = $_POST['id_evento'];
  }

?>
<div class="container-fluid">
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4">
      <center><img src="img/sicade.png" alt="" class="img-responsive"></center>
    </div>
  </div>

  <div class="row">
  	<div class="col-md-6 col-md-offset-3">
  		<center><h3>Para participar de um evento você precisa de uma conta.</h3></center>
  	</div>
  </div>

  <div class="row">
  	<div class="col-md-4 col-md-offset-4">
  		<center>
  			<a href="#" data-toggle="modal" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-primary btn-lg">Crie uma conta é grátis.</a>
  			<a href="login.php">Já tenho conta</a>
  		</center>
  	</div>  	
  </div>	
</div>

<!-- modal criar conta -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Crie sua conta. É gratuito e sempre será.</h4>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#form_aluno" data-toggle="tab">Aluno</a></li>
          <li><a href="#form_visitante" data-toggle="tab">Visitante</a></li>
          <li><a href="#form_palestrante" data-toggle="tab">Palestrante</a></li>
        </ul>

        <div class="tab-content">
          <!--BEGIN FORM CADASTRO DE ALUNO-->
          <div class="tab-pane active" id="form_aluno">
            <form action="controller/index.php" method="post" data-toggle="validator">
              <input type="hidden" name="action" value="cadastrar_aluno">
              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="name">Nome: </label>
                  <input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
                  <span class="gliphycon form-control-feedback"></span>
                  <span class="help-block with-errors"></span>
                </div>

                <div class="col-md-3 form-group">
                  <label for="cpf">Cpf: </label>
                  <input type="text" name="cpf" id="cpf_aluno" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onblur="javascript: validarCPFAluno(this);" onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14">
                  <span id="cpf_aluno-invalido" style="background-color: #F2DEDE; color: #A94442;"></span>
                  <span id="cpf_aluno-valido" style="background-color: #D9EDF7; color: #31708F;"></span>
                  <small class="help-block with-errors">Ex: 123.456.789-81</small>
                </div>

                <div class="col-md-4 form-group has-feedback">
                  <label for="email">E-mail: </label>
                  <input type="email" name="email" class="form-control" required="true" placeholder="Seu melhor email" data-error="Preencha este campo." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-3 form-group has-feedback">
                  <label for="curso">Curso: </label>
                  <select name="curso" id="curso" class="form-control" required="true" data-error="Selecione seu curso">
                    <?php 
                      $PDO = connection();

                      try{
                        // inicia a transação
                        $PDO->beginTransaction();

                        $sql = "SELECT *FROM curso";

                        $statement = $PDO->prepare($sql);

                        $statement->execute();

                        if($statement->rowCount() != 0){
                          while($lista_cursos = $statement->fetch(pdo::FETCH_ASSOC)){?>
                          <option value="<?=$lista_cursos['id_curso']?>"><?=$lista_cursos['nome']?></option>
                          <?php
                          }
                          $PDO->commit();
                        }
                      }catch(pdoexception $e){
                        echo 'Falha ao buscar cursos: '.$e->getMessage();
                        $PDO->rollBack();
                      }
                     ?>
                    </select>
                    <span class="glyphicon form-control-feedback"></span>
                    <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-2 form-group">
                  <label for="periodo">Periodo: </label>
                  <select class="form-control" name="periodo" required="true">
                    <option value="1">1°</option>
                    <option value="2">2°</option>
                    <option value="3">3°</option>
                    <option value="4">4°</option>
                    <option value="5">5°</option>
                    <option value="6">6°</option>
                    <option value="7">7°</option>
                    <option value="8">8°</option>
                    <option value="9">9°</option>
                    <option value="10">10</option>
                  </select>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="celular">Celular: </label>
                  <input type="tel" name="celular" class="form-control" required="true" placeholder="Somente numeros" pattern=".{14,14}" data-error="Preencha este campo." onkeyup="criaMascara(this,'(##)#####-####');">
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block with-errors"></span>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="endereco">Endereço: </label>
                  <input type="text" name="endereco" class="form-control" required="true" placeholder="Onde você mora?" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="bairro">Bairro: </label>
                  <input type="text" name="bairro" class="form-control" required="true" placeholder="Qual bairro?" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-2 form-group has-feedback">
                  <label for="numero">N°</label>
                  <input type="number" name="numero" min="1" class="form-control" required="true" placeholder="0">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="estado">Estado: </label>
                  <select name="estado" id="estado" class="form-control" required="true" data-error="Selecione um estado."></select>
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-4 form-group has-feedback">
                  <label for="cidade">Cidade: </label>
                  <select name="cidade" id="cidade" class="form-control" required="true" data-error="Selecione uma cidade."></select>
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="user_name">Usuário: </label>
                  <input type="text" name="user_name" class="form-control" required="true" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="password">Senha: </label>
                  <input type="password" id="password_aluno" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="repeat-password">Repetir senha: </label>
                  <input type="password" id="repeat-password" name="repeat-password" data-match="#password_aluno" class="form-control" required="true" data-error="Senhas devem ser iguais.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">Criar Conta</button>
                  <button type="reset" class="btn btn-default">Limpar</button>
                </div>
              </div><!--row < form-->
            </form><!--end form-->
          </div>
          <!--END FORM CADASTRO DE ALUNO-->
          
          <!--BEGIN FORM CADASTRO DE VISITANTE-->
          <div class="tab-pane" id="form_visitante">
            <form action="controller/index.php" method="post" data-toggle="validator">
              <input type="hidden" name="action" value="cadastrar_visitante" >
              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="name">Nome: </label>
                  <input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group">
                  <label for="cpf">Cpf: </label>
                  <input type="text" name="cpf" id="cpf_visitante" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onblur="javascript: validarCPFVisitante(this);" onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14">
                  <span id="cpf_visitante-invalido" style="background-color: #F2DEDE; color: #A94442;"></span>
                  <span id="cpf_visitante-valido" style="background-color: #D9EDF7; color: #31708F;"></span>
                  <small class="help-block with-errors">Ex: 123.456.789-81</small>
                </div>

              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="email">E-mail: </label>
                  <input type="email" name="email" class="form-control" required="true" placeholder="Seu melhor email" data-error="Preencha este campo." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="celular">Celular: </label>
                  <input type="tel" name="celular" class="form-control" required="true" placeholder="Somente numeros" pattern=".{14,14}" data-error="Preencha este campo." onkeyup="criaMascara(this, '(##)#####-####');">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="user_name">Usuário: </label>
                  <input type="text" name="user_name" class="form-control" required="true" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="password">Senha: </label>
                  <input type="password" id="password_visitante" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="repeat-password">Repetir senha: </label>
                  <input type="password" id="repeat-password" name="repeat-password" data-match="#password_visitante" class="form-control" required="true" data-error="Senhas devem ser iguais.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">Criar Conta</button>
                  <button type="reset" class="btn btn-default">Limpar</button>
                </div>
              </div><!--row < form-->
            </form><!--form-->
          </div>
          <!--END FORM CADASTRO DE VISITANTE-->
          
          <!--BEGIN FORM CADASTRO DE PALESTRANTE-->
          <div class="tab-pane" id="form_palestrante">
            <form action="controller/index.php" method="post" data-toggle="validator">
              <input type="hidden" name="action" value="cadastrar_palestrante" >
              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="name">Nome: </label>
                  <input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group">
                  <label for="cpf">Cpf: </label>
                  <input type="text" name="cpf" id="cpf_palestrante" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onblur="javascript: validarCPFPalestrante(this);" onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14">
                  <span id="cpf_palestrante-invalido" style="background-color: #F2DEDE; color: #A94442;"></span>
                  <span id="cpf_palestrante-valido" style="background-color: #D9EDF7; color: #31708F;"></span>
                  <small class="help-block with-errors">Ex: 123.456.789-81</small>
                </div>

                <div class="col-md-4 form-group has-feedback">
                  <label for="email">E-mail: </label>
                  <input type="email" name="email" class="form-control" required="true" placeholder="Seu melhor email" data-error="Preencha este campo." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="endereco">Endereço: </label>
                  <input type="text" name="endereco" class="form-control" required="true" placeholder="Onde você mora?" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="bairro">Bairro: </label>
                  <input type="text" name="bairro" class="form-control" required="true" placeholder="Qual bairro?" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-2 form-group has-feedback">
                  <label for="numero">N°</label>
                  <input type="number" name="numero" min="1" class="form-control" required="true" placeholder="0">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="celular">Celular: </label>
                  <input type="tel" name="celular" class="form-control" required="true" placeholder="Somente numeros" pattern=".{14,14}" data-error="Preencha este campo." onkeyup="criaMascara(this, '(##)#####-####');">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="estado">Estado: </label>
                  <select name="estado" id="estado1" class="form-control" required="true" data-error="Selecione um estado."></select>
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-4 form-group has-feedback">
                  <label for="cidade">Cidade: </label>
                  <select name="cidade" id="cidade1" class="form-control" required="true" data-error="Selecione uma cidade."></select>
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="user_name">Usuário: </label>
                  <input type="text" name="user_name" class="form-control" required="true" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="password">Senha: </label>
                  <input type="password" id="password_palestrante" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="repeat-password">Repetir senha: </label>
                  <input type="password" id="repeat-password" name="repeat-password" data-match="#password_palestrante" class="form-control" required="true" data-error="Senhas devem ser iguais.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>
              </div><!--row < form-->

              <div class="row">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">Criar Conta</button>
                  <button type="reset" class="btn btn-default">Limpar</button>
                </div>
              </div><!--row < form-->
            </form><!--form-->
          </div>
          <!--END FORM CADASTRO DE PALESTRANTE-->
        </div><!--tab content-->
      </div><!--modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!--Inclusão do rodapé-->
<?php 
	include 'include/footer.php';
?>