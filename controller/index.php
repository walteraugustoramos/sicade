<?php 
	session_start();
	include '../include/config.php';
	include '../model/Visitante.class.php';
	include 'VisitanteDAO.class.php';
	include '../model/UserLogin.class.php';
	include 'UserLoginDAO.class.php';
	include '../model/Aluno.class.php';
	include 'AlunoDAO.class.php';

	// verifico se existe sessão para o usuario, se não existir redireciono para pagina de login com uma mensagem de error
	if(!empty($_SESSION['user']['name']) && !empty($_SESSION['user']['password'])){
		// verifico a permissão do usuario e redireciono para o modulo especifico
		if($_SESSION['user']['nivel'] == '0'){
			header('Location:../modulo_adm/index.php');
		}else if($_SESSION['user']['nivel'] == '1'){
			header('Location:../modulo_palestrante/index.php');
		}else if($_SESSION['user']['nivel'] == '2'){
			header('Location:../modulo_aluno/index.php');
		}else if($_SESSION['user']['nivel'] == '3'){
			header('Location:../modulo_visitante/index.php');
		}
	}else if($_POST['action'] == 'cadastrar_visitante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../login.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$visitante = new Visitante();
			$visitanteDAO = new VisitanteDAO();
			$user_login = new UserLogin();
			$user_loginDAO = new UserLoginDAO();

			$visitante->setName($name);
			$visitante->setCpf($cpf);
			$visitante->setEmail($email);
			$visitante->setCelular($celular);

			$user_login->setName($user_name);
			$user_login->setPassword($password);
			$user_login->setNivel('3');	

			if($visitanteDAO->cadastrarVisitante($visitante,$user_login)){
				$user_loginDAO->Login($user_login->getName(),$user_login->getPassword());
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Visitante!!!";
				header("Location:../login.php");
			}
		}
	}else if($_POST['action'] == 'cadastrar_aluno'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../login.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$aluno = new Aluno();
			$alunoDAO = new AlunoDAO();
			$user_login = new UserLogin();
			$user_loginDAO = new UserLoginDAO();

			$aluno->setName($name);
			$aluno->setCpf($cpf);
			$aluno->setEmail($email);
			$aluno->setEndereco($endereco);
			$aluno->setNumero($numero);
			$aluno->setBairro($bairro);
			$aluno->setEstado($estado);
			$aluno->setCidade($cidade);
			$aluno->setCelular($celular);
			$aluno->setPeriodo($periodo);

			$user_login->setName($user_name);
			$user_login->setPassword($password);
			$user_login->setNivel('2');	

			if($alunoDAO->cadastrarAluno($aluno,$user_login,$curso)){
				$user_loginDAO->Login($user_login->getName(),$user_login->getPassword());
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Aluno!!!";
				header('Location:../login.php');
			}
		}	
	}
	else{
		$_SESSION['msg']['error'] = 'Faça Login';
		header('Location:../login.php');
	}
 ?>