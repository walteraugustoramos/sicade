<!--Inclusão do menu principal do visitante-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/VisitanteDAO.class.php';
  include '../controller/EventoDAO.class.php';

  $eventoDAO = new EventoDAO();
  $visitanteDAO = new VisitanteDAO();

  // retorna um array contendo os dados do visitante que está logado no sistema
  $visitante = $visitanteDAO->getVisitante($_SESSION['user']['id']);

  if($visitanteDAO->getEventoVisitante($visitante['id_visitante'], 1) != 0){
    // retorna um array contendo os ids dos eventos que o visitante está presente
    $eventos_ids = $visitanteDAO->getEventoVisitante($visitante['id_visitante'], 1);
  
    for($i = 0; $i < count($eventos_ids); $i++){
      if($eventoDAO->getEvento($eventos_ids[$i]['evento_id_evento'],0) != 0){
        // retorna um array contendo todas as informações dos eventos que o visitante participou
        $eventos_dados[] = $eventoDAO->getEvento($eventos_ids[$i]['evento_id_evento'],0);
      }
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
    <div class="table-responsive table-hover table-striped col-md-6 col-md-offset-3">
      <table class="table" id="list-certificados">
        <thead>
          <tr>
            <th>Evento</th>
            <th>Carga Horaria</th>
            <th class="actions">Ação</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            foreach($eventos_dados as $evento){
           ?>
           <tr>
            <td><?php echo $evento['nome']?></td>
            <td><?php echo $evento['carga_horaria']?></td>
            <td>
                <a href="controller/index.php?action=gerar_certificado&id_visitante=<?=$visitante['id_visitante']?>&id_evento=<?=$evento['id_evento']?>" class="btn btn-primary btn-xs" target="_blank">Gerar Certificado</a>
            </td>
          </tr>
          <?php 
            }// fechamento do foreach($eventos_dados as $evento)
          }else{?>
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-warning" role="alert">
                  <span><center>Desculpe, nenhum certificado disponivel ainda.</center></span>
                </div>
              </div>
            </div>
          <?php }// fechamento do else?>
        </tbody>
      </table>
    </div>
  </div>
</div><!--container-fluid-->
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>