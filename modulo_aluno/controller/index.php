<?php 
	session_start();
	define('_MPDF_PATH', '../../mpdf60/');// indica o caminho dos arquivos da biblioteca MPDF
	include(_MPDF_PATH.'mpdf.php');// Inclui o arquivo de configuração da biblioteca MPDF
	include '../../include/config.php';
	include '../../model/Aluno.class.php';
	include '../../controller/AlunoDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../controller/UserLoginDAO.class.php';
	include '../../controller/EventoDAO.class.php';
	include '../../controller/PalestranteDAO.class.php';
		// verifico se existe sessão para o usuario, caso não exista redireciono para a pagina de login
	if(empty($_SESSION['user']['name']) && empty($_SESSION['user']['password'])){
		$_SESSION['msg']['error'] = 'Faça Login';
    	header('Location:../../login.php');
	}else if($_POST['action'] == 'editar_aluno'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_aluno.php');
		}else{// todos os campos do formulario foram preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$aluno = new Aluno();
			$alunoDAO = new AlunoDAO();

			$aluno->setId($id_aluno);
			$aluno->setName($name);
			$aluno->setEmail($email);
			$aluno->setEndereco($endereco);
			$aluno->setNumero($numero);
			$aluno->setBairro($bairro);
			$aluno->setEstado($estado);
			$aluno->setCidade($cidade);
			$aluno->setCelular($celular);
			$aluno->setPeriodo($periodo);

			if($alunoDAO->editarAluno($aluno,$curso)){
				$_SESSION['msg']['success'] = "Dados Editados com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Editar Dados!!!";
				header("Location:../index.php");
			}
			
		}
	}else if($_POST['action'] == 'editar_senha_aluno'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_senha_aluno.php');
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
	}else if($_POST['action'] == 'inscrever_aluno'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../index.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$alunoDAO = new AlunoDAO();
			$eventoDAO = new EventoDAO();

			$aluno = $alunoDAO->getAluno($_SESSION['user']['id']);
			
			if($alunoDAO->inscreverAluno($aluno['id_aluno'],$id_evento) && $eventoDAO->setQuantidadeInscritosEvento($id_evento,($quantidade_inscritos+1))){
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
	}else if($_GET['action'] == 'gerar_certificado'){
		// tratamento para caso as variaveis enviadas via get sejam modificadas na url com valores invalidos
		if(empty($_GET['id_aluno']) || empty($_GET['id_evento'])){
			$_SESSION['msg']['error'] = 'Erro ao Gerar Certificado.';
			 header('Location:../index.php');
		}else{
			foreach($_GET as $key => $value){
					$$key = $value;
			}
			$alunoDAO = new AlunoDAO();
			$alunoDAO->gerarCertificadoAluno($id_aluno, $id_evento);
		}// fechamento do else
	}
 ?>