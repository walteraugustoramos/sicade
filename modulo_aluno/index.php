<!--Inclusão do menu principal do aluno-->
<?php
  include 'include/header.php';
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-3">
			<?php
              if(!empty($_SESSION['msg']['success'])){?>
                <div class="alert alert-success" role="alert">
                  <center><?=$_SESSION['msg']['success']?>
                  </center>
                </div>
                <?php
                  unset($_SESSION['msg']['success']);
                }
            ?>
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
		</div>
	</div>
</div>
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>