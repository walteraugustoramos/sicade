<?php 
  session_start();
  include 'config.php';

 ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    <title>Sicade</title>
    
    <!--Style Personalizado-->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap -->
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Script Combobox Estados e Cidades-->
    <script language="JavaScript" type="text/javascript" src="js/cidades-estados-1.4-utf8.js"></script>
    
    <!--Css style JqueryUi necessario para funcionamento do autocomplete
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">

    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">
        <span>SICADE</span>
      </a>
      </div><!--navbar-header-->
    
      <!--Inicio Menu-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-11">
            <div class="collapse navbar-collapse menu" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Certificado<span class="caret"></span></a>
                <!--dropdown home-->
                  <ul class="dropdown-menu">
                    <li><a href="validar_certificado.php">Verificar Validade</a></li>
                  </ul><!--dropdown home-->                  
                </li>
              </ul><!--ul-->
            </div><!--navbar-collapse-->
          </div><!--col-md-12-->
        </div><!--row-->
      </div><!--container-fluid-->    
    </nav><!--navbar-->