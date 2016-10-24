<!--Inclusão do menu principal da index do site-->
<?php
  include 'include/header.php';
?>
<div class="container-fluid">
  <div class="row" style="margin-top: 2em;">
    <div class="col-md-4 col-md-offset-5 col-xs-4 col-xs-offset-4">
      <img src="img/sicade.png" alt="" class="img-responsive">
    </div>
  </div>

	<div class="row" style="margin-top: 1em;">
		<div class="col-md-6 col-md-offset-3 form-group">
			<input type="text" id="busca" class="form-control">
		</div>
	</div>

	<div class="row">
		<div class="col-md-11 col-md-offset-1">
			<div class="row form_dados">
				<form action="confirme_login.php" method="post">
          <input type="hidden" id="id_evento" name="id_evento">
  				<div class="col-md-3 form-group">
  					<label for="nome">Evento</label>
  					<input type="text" id="nome" class="form-control form_evento" readonly>
  				</div>

  				<div class="col-md-3 form-group">
  					<label for="nome">Data</label>
  					<input type="text" id="data_inicio" class="form-control form_evento" readonly>
  				</div>

  				<div class="col-md-2 form-group">
  					<label for="nome">Carga Horaria</label>
  					<input type="text" id="carga_horaria" class="form-control form_evento" readonly>
  				</div>

          <div class="col-md-2 form-group">
            <label for="nome">Quantidade Vagas</label>
            <input type="text" name="quantidade_vagas" id="quantidade_vagas" class="form-control form_evento" readonly required="true">
          </div>

  				<div class="col-md-2 form-group">
            <button type="submit" class="btn btn-primary" id="participar" style="margin-top: 1.7em;" disabled>Participar</button>
  				</div>
        </form>
			</div>
		</div>
	</div>
</div>
<!--Inclusão do rodapé-->
<?php 
	include 'include/footer.php';
?>