<?php
	include 'include/header.php';
?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4 col-md-offset-4" style="margin-top:15em;">      
          <form action="#" method="post" class="form-signin" data-toggle="validator">
            
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
            <span><a href="#">Criar uma conta</a></span>
          </form>
        </div>
      </div><!--row-->
    </div><!--container-fluid-->

<?php
	include 'include/footer.php';
?>