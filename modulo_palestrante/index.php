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

  // retorna um array contendo os eventos cadastrados por o palestrante que está logado no sistema
  $palestrante_has_evento = $palestranteDAO->getPalestrantehasEvento($palestrante['id_palestrante']);
  

  for($i = 0; $i < count($palestrante_has_evento); $i++){
    // retorna um arrauy contendo todas as informações do evento cadastrado pelo palestrante
    $eventos_dados[] = $eventoDAO->getEvento($palestrante_has_evento[$i]['evento_id_evento']);
  }
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
  <div id="list" class="row">
    <div class="table-responsive table-striped table-hover col-md-6 col-md-offset-3">
      <table class="table">
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
              <a href="#" class="btn btn-success btn-xs">Chamada</a>
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
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>