<?php 
	session_start();
	define('_MPDF_PATH', '../../mpdf60/');// indica o caminho dos arquivos da biblioteca MPDF
	include(_MPDF_PATH.'mpdf.php');// Inclui o arquivo de configuração da biblioteca MPDF
	include '../../include/config.php';
	include '../../model/Visitante.class.php';
	include '../../controller/VisitanteDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../controller/UserLoginDAO.class.php';
	include '../../controller/EventoDAO.class.php';
	include '../../controller/PalestranteDAO.class.php';

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
			$eventoDAO = new EventoDAO();

			$visitante = $visitanteDAO->getVisitante($_SESSION['user']['id']);

			if($visitanteDAO->inscreverVisitante($visitante['id_visitante'],$id_evento) && $eventoDAO->setQuantidadeInscritosEvento($id_evento,($quantidade_inscritos+1))){
				$_SESSION['msg']['success'] = 'Inscrição realizada com sucesso.';
			 	header('Location:../index.php');
			}else{
				$_SESSION['msg']['error'] = 'Desculpe mas você já se inscreveu neste evento.';
			 	header('Location:../index.php');
			}		
		}
	}else if($_GET['action'] == 'gerar_certificado'){
		// tratamento para caso as variaveis enviadas via get sejam modificadas na url com valores invalidos
		if(empty($_GET['id_visitante']) || empty($_GET['id_evento'])){
			$_SESSION['msg']['error'] = 'Erro ao Gerar Certificado.';
			 header('Location:../index.php');
		}else{
			foreach($_GET as $key => $value){
					$$key = $value;
			}
			$visitanteDAO = new VisitanteDAO();
			$visitanteDAO->gerarCertificadoVisitante($id_visitante, $id_evento);
		}// fechamento do else
	}
 ?>