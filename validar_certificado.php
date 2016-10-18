<!--Inclusão do menu principal da index do site-->
<?php
  include 'include/header.php';
?>
<div class="container-fluid">
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4">
      <center><img src="img/sicade.png" alt="" class="img-responsive"></center>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4 col-md-offset-4" style="margin-top: 2em;">
      <h2><center>Validação de Certificado</center></h2>
    </div>
  </div>

  <form action="controller/index.php" method="post" data-toggle="validator">
    <input type="hidden" name="action" value="consultar_validade_certificado">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 form-group has-feedback" style="margin-top: 2em;">
        <center>
          <label for="chave_validacao_certificado" style="color: #FF8A8A">Para verificar a autenticidade do certificado emitido pelo Sicade, informe a chave de validação do certificado.</label>
          <input type="text" name="chave_validacao_certificado" required="true" class="form-control" maxlength="32" minlength="32" data-error="Digite a chave de validação impressa no certificado." placeholder="d7466182cfe8de0de09e4d064290d6e3">
          <span class="glyphicon form-control-feedback"></span>
          <small class="help-block with-errors"></small>
        </center>
      </div>
    </div><!--row < form-->

    <div class="row">
      <div class="col-md-2 col-md-offset-4 form-group has-feedback">
        <label for="nivel">Você é?</label>
        <select name="nivel" id="nivel" class="form-control">
          <option value="1">Palestrante</option>
          <option value="2" selected="true">Aluno</option>
          <option value="3">Visitante</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-md-2 col-md-offset-4 form-group">
        <button type="submit" class="btn btn-primary">Validar</button>
      </div>
    </div><!--row < form-->
  </form>

  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <?php
              if(!empty($_SESSION['certificado']['valido'])){?>
                <div class="alert alert-success" role="alert">
                  <center><?=$_SESSION['certificado']['valido']?>
                  </center>
                </div>
                <?php
                  unset($_SESSION['certificado']['valido']);
                }
            ?>
      <?php
              if(!empty($_SESSION['certificado']['invalido'])){?>
                <div class="alert alert-warning" role="alert">
                  <center><?=$_SESSION['certificado']['invalido']?>
                  </center>
                </div>
                <?php
                  unset($_SESSION['certificado']['invalido']);
                }
            ?>
    </div>
  </div>
</div><!--container-fluid-->
<!--Inclusão do rodapé-->
<?php 
	include 'include/footer.php';
?>