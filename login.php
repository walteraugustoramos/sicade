<?php
	include 'include/header.php';
?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3 col-sm-5">
          <img src="img/logo_sicade.jpg" alt="" class="img-responsive img-rounded">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-md-offset-4">      
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
            <span><a href="#" data-toggle="modal" data-toggle="modal" data-target=".bs-example-modal-lg">Criar uma conta</a></span>
          </form>
        </div>
      </div><!--row-->
    </div><!--container-fluid-->

<!-- Large modal -->
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
            <form action="#" method="post" data-toggle="validator">
              <input type="hidden" name="action" value="cadastrar_aluno">
              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="name">Nome: </label>
                  <input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
                  <span class="gliphycon form-control-feedback"></span>
                  <span class="help-block with-errors"></span>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="cpf">Cpf: </label>
                  <input type="text" name="cpf" id="cpf" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onkeyup="criaMascara(this,'###.###.###-##');" maxlength="14">
                  <span class="gliphycon form-control-feedback"></span>
                  <span class="help-block with-errors"></span>
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
                  <input type="password" id="" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="repeat-password">Repetir senha: </label>
                  <input type="password" id="repeat-password" name="repeat-password" data-match="" class="form-control" required="true" data-error="Senhas devem ser iguais.">
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

                <div class="col-md-3 form-group has-feedback">
                  <label for="cpf">Cpf: </label>
                  <input type="text" name="cpf" id="cpf" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
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
                  <input type="password" id="password" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="repeat-password">Repetir senha: </label>
                  <input type="password" id="repeat-password" name="repeat-password" data-match="#password" class="form-control" required="true" data-error="Senhas devem ser iguais.">
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
            <form action="#" method="post" data-toggle="validator">
              <input type="hidden" name="action" value="cadastrar_palestrante" >
              <div class="row">
                <div class="col-md-4 form-group has-feedback">
                  <label for="name">Nome: </label>
                  <input type="text" name="name" class="form-control" autofocus="true" required="true" placeholder="Nome Completo" data-error="Preencha este campo.">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="cpf">Cpf: </label>
                  <input type="text" name="cpf" id="cpf" class="form-control" required="true" placeholder="Somente numeros" data-error="Preencha este campo." onkeyup="criaMascara(this, '###.###.###-##');" maxlength="14">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
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
                  <input type="password" id="" name="password" class="form-control" required="true" data-minlength="8" data-error="Sua senha deve ter no minimo 8 caracteres">
                  <span class="glyphicon form-control-feedback"></span>
                  <small class="help-block with-errors"></small>
                </div>

                <div class="col-md-3 form-group has-feedback">
                  <label for="repeat-password">Repetir senha: </label>
                  <input type="password" id="repeat-password" name="repeat-password" data-match="" class="form-control" required="true" data-error="Senhas devem ser iguais.">
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

<?php
	include 'include/footer.php';
?>