<?php 
	session_start();
	include '../../include/config.php';
	include '../../model/Visitante.class.php';
	include '../../controller/VisitanteDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../controller/UserLoginDAO.class.php';
	// verifico se existe sessão para o usuario, caso não exista redireciono para a pagina de login
	if(empty($_SESSION['user']['name']) && empty($_SESSION['user']['password'])){
		$_SESSION['msg']['error'] = 'Faça Login';
    	header('Location:../../login.php');
	}else if($_POST['action'] == 'editar_visitante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_visitante.php');
		}else{// todos os campos do formulario foram preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$visitante = new Visitante();
			$visitanteDAO = new VisitanteDAO();

			$visitante->setId($id_visitante);
			$visitante->setName($name);
			$visitante->setEmail($email);
			$visitante->setCelular($celular);

			if($visitanteDAO->editarVisitante($visitante)){
				$_SESSION['msg']['success'] = "Dados Editados com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Editar Dados!!!";
				header("Location:../index.php");
			}
		}
	}else if($_POST['action'] == 'editar_senha_visitante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_senha_visitante.php');
		}else{// todos os campos do formulario foram preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$user_login = new UserLogin();
			$user_login_DAO = new UserLoginDAO();

			$user_login->setId($_SESSION['user']['id']);
			$user_login->setPassword($password);

			if($user_login_DAO->editarUserLogin($user_login)){
				$_SESSION['msg']['success'] = "Senha Editada com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Editar Senha!!!";
				header("Location:../index.php");
			}
		}
	}else if($_POST['action'] == 'inscrever_visitante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../index.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$visitanteDAO = new VisitanteDAO();

			$visitante = $visitanteDAO->getVisitante($_SESSION['user']['id']);
			
			if($visitanteDAO->inscreverVisitante($visitante['id_visitante'],$id_evento)){
				$_SESSION['msg']['success'] = 'Inscrição realizada com sucesso.';
			 	header('Location:../index.php');
			}else{
				$_SESSION['msg']['error'] = 'Desculpe mas você já se inscreveu neste evento.';
			 	header('Location:../index.php');
			}
			
		}
	}else if($_POST['action'] == 'gerar_certificado'){
		echo "<pre>";
		var_dump($_POST);
		echo "</pre>";

		foreach($_POST as $key => $value){
				$$key = $value;
		}
	}
 ?>