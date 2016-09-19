<?php 
	session_start();

	// verifico se existe sessão para o usuario, se não existir redireciono para pagina de login com uma mensagem de error
	if(!empty($_SESSION)){
		// verifico a permissão do usuario e redireciono para o modulo especifico
		if($_SESSION['user']['nivel'] == '0'){
			header('Location:../modulo_adm/index.php');
		}
	}else{
		$_SESSION['msg']['error'] = 'Faça Login';
		header('Location:../login.php');
	}
 ?>