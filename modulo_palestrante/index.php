<!--Inclusão do menu principal do palestrante-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/PalestranteDAO.class.php';
  include '../controller/EventoDAO.class.php';

  $palestranteDAO = new PalestranteDAO();
  $eventoDAO = new EventoDAO();

  // retorna um array contendo todos os dados do palestrante que está logado no sistema
  $palestrante = $palestranteDAO->getPalestrante($_SESSION['user']['id']);

  //verifico se existem eventos cadastrados pelo palestrante
  if($palestranteDAO->getPalestrantehasEvento($palestrante['id_palestrante']) != 0){
	  // retorna um array contendo os ids dos eventos cadastrados por o palestrante que está logado no sistema
	  $palestrante_has_evento = $palestranteDAO->getPalestrantehasEvento($palestrante['id_palestrante']);

	  for($i = 0; $i < count($palestrante_has_evento); $i++){
	    // retorna um arrauy contendo todas as informações dos eventos cadastrado pelo palestrante que ainda não aconteceram
	    if($eventoDAO->getEvento($palestrante_has_evento[$i]['evento_id_evento'],1) != 0){
	      $eventos_dados[] = $eventoDAO->getEvento($palestrante_has_evento[$i]['evento_id_evento'],1);
	    }
	  }
?>
<div class="container-fluid">
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-5 col-xs-4 col-xs-offset-4">
      <img src="../img/sicade.png" alt="" class="img-responsive">
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
              <a href="chamada_evento.php?id_evento=<?=$evento['id_evento']?>&id_palestrante=<?=$palestrante['id_palestrante']?>" class="btn btn-success btn-xs">Chamada</a>
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
				<center><span class="alert alert-warning" role="alert">Cadastre um evento para palestrar.</span></center>
			</div>
		</div>
	</div>
	<?php
	}// fechamento do else
 ?>
   <div class="row" style="margin-top: 2em;">
    <div class="col-md-3 col-md-offset-5">
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
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>