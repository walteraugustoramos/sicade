<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/EventoDAO.class.php';;

  $eventoDAO = new EventoDAO();

  // verifico se existe algum evento cadastrado
  if($eventoDAO->getAllEvento(1) != 0){
    // busco todos os eventos que ainda não aconteceram
    $eventos_dados = $eventoDAO->getAllEvento(1);
  
?>
<div class="container-fluid">
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-5 col-xs-4 col-xs-offset-4">
      <img src="../img/sicade.png" alt="Sicade" class="img-responsive" title="Sicade">
    </div>
  </div>
  <div id="list" class="row" style="margin-top: 2em;">
    <div class="table-responsive table-striped table-hover col-md-6 col-md-offset-3">
      <table class="table" id="list-eventos">
        <thead>
          <tr>
            <th>Evento</th>
            <th class="actions">Ação</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            foreach($eventos_dados as $evento){
           ?>
          <tr>
            <td><?=$evento['nome']?></td>
            <td class="actions">
              <a href="chamada_evento.php?id_evento=<?=$evento['id_evento']?>" class="btn btn-success btn-xs">Chamada</a>
              <a href="form_editar_evento.php?id_evento=<?=$evento['id_evento']?>" class="btn btn-warning btn-xs">Editar</a>
            </td>
          </tr>
          <?php 
            }// fechamento foreach($eventos_dados as $evento)
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php 
  }else{?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-md-offset-5">
        <center><span class="alert alert-warning" role="alert">Nenhum evento cadastrado.</span></center>
      </div>
    </div>
  </div>
<?php
  }// fechamento do else
 ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
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