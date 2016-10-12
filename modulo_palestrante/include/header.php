<?php 
	session_start();
  // verifico se existe sessao para o usuario, se não existir sessão redireciono para pagina de login
  if(empty($_SESSION['user']['name']) && empty($_SESSION['user']['password'])){
    $_SESSION['msg']['error'] = 'Faça Login';
    header('Location:../login.php');
  }
 ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sicade Palestrante</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--Script Combobox Estados e Cidades-->
    <script language="JavaScript" type="text/javascript" src="js/cidades-estados-1.4-utf8.js"></script>

     <!--Arquivos necessários para funcionamento do datepickertime-->
    <script type="text/javascript" src="js/moment.min.js"></script>
    
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div><!--navbar-header-->
    
      <!--Inicio Menu-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 col-md-offset-4">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li class="dropdown">
          			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil<span class="caret"></span></a>
          			<!--dropdown palestrante-->
          			<ul class="dropdown-menu">
            			<li><a href="form_editar_palestrante.php">Alterar Meus Dados</a></li>
            			<li><a href="form_editar_senha_palestrante.php">Alterar Senha</a></li>
          			</ul><!--dropdown palestrante-->
        		</li><!--dropdown-->

        		<li class="dropdown">
          			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Evento <span class="caret"></span></a>
          			<!--dropdown evento-->
          			<ul class="dropdown-menu">
            			<li><a href="form_cadastrar_evento.php">Cadastrar</a></li>
          			</ul><!--dropdown evento-->
        		</li><!--dropdown-->

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Certificado <span class="caret"></span></a>
                <!--dropdown certificado-->
                <ul class="dropdown-menu">
                  <li><a href="#">Consultar</a></li>
                </ul><!--dropdown certificado-->
            </li><!--dropdown-->
				
				<li><a href="../controller/logout.php">Sair</a></li>
              </ul><!--ul-->
            </div><!--navbar-collapse-->
          </div><!--col-md-12-->
        </div><!--row-->
      </div><!--container-fluid-->    
    </nav><!--navbar-->