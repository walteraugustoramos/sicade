<!--Inclusão do menu principal do administrador-->
<?php
  include 'include/header.php';
  include '../include/config.php';
  include '../controller/CursoDAO.class.php';

  $cursoDAO = new CursoDAO();
?>

<div class="container-fluid">
	<div class="row" style="margin-bottom: 1em;">
		<div class="col-md-4 col-md-offset-4">
			<center><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#cadastrar-curso">Cadastrar Curso</a></center>
		</div>
	</div>
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
	<?php 
		if($cursoDAO->getAllCurso() != false){
  			$cursos = $cursoDAO->getAllCurso();
	 ?>
	<div id="list" class="row">
		<div class="table-responsive table-striped table-hover col-md-6 col-md-offset-3">
			<table class="table" id="list-cursos">
				<thead>
					<tr>
						<th>Curso</th>
						<th class="actions">Ação</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($cursos as $curso){?>
					<tr>
						<form action="curso.php" method="post">
							<input type="hidden" name="id_curso" value="<?=$curso['id_curso']?>">
							<input type="hidden" name="curso_nome" value="<?=$curso['nome']?>">
							<td><?=$curso['nome']?></td>
							<td><button type="submit" class="btn btn-warning btn-xs">Editar</button></td>
						</form>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	
	<?php
		if(!empty($_POST['curso_nome'])){
	 ?>
	
	<form action="controller/index.php" method="post" data-toggle="validator">
		<div class="row">
			<div class="col-md-3 col-md-offset-4 form-group has-feedback">
				<input type="hidden" name="action" value="editar_curso">
				<input type="hidden" name="id_curso" value="<?=$_POST['id_curso']?>">
				<label for="nome">Curso Editar: </label>
				<input type="text" class="form-control" name="curso_name" value="<?=$_POST['curso_nome']?>" required="true" data-error="Preencha este campo." autoFocus="true">
				<span class="glyphicon form-control-feedback"></span>
				<small class="help-block with-errors"></small>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-4">
				<button type="submit" class="btn btn-primary btn-xs">Salvar</button>
			</div>
		</div>
	</form>
	<?php } ?>
</div><!--container-fluid-->

<?php 
	}else{?>
		<div class="row">
          <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-warning" role="alert">
              <span><center>Cadastre um curso para os alunos se inscreverem.</center></span>
            </div>
          </div>
        </div>		
	<?php
	}// fechamento do else
 ?>

 <!-- Modal cadastrar curso -->
<div class="modal fade" id="cadastrar-curso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cadastrar Curso</h4>
      </div>
      <div class="modal-body">
		<form action="controller/index.php" method="post" data-toggle="validator">
			<input type="hidden" name="action" value="cadastrar_curso" >
			<div class="row">
				<div class="col-md-8 form-group has-feedback">
					<label for="nome_curso">Curso: </label>
					<input type="text" name="nome_curso" class="form-control" autofocus="true" required="true" placeholder="Nome do Curso" data-error="Preencha este campo.">
					<span class="glyphicon form-control-feedback"></span>
					<small class="help-block with-errors">Ex: Sistemas de Informação</small>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary">Salvar</button>
					<button type="reset" class="btn btn-default">Limpar</button>
				</div>
			</div><!--row < form-->
		</form><!--form < col-md-12-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Fim modal cadastrar curso-->
<!--Inclusão do rodapé-->
<?php 
  include 'include/footer.php';
?>