<?php 
	session_start();
	include '../include/config.php';
	include '../model/Visitante.class.php';
	include 'VisitanteDAO.class.php';
	include '../model/UserLogin.class.php';
	include 'UserLoginDAO.class.php';
	include '../model/Aluno.class.php';
	include 'AlunoDAO.class.php';
	include '../model/Palestrante.class.php';
	include 'PalestranteDAO.class.php';

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
	}else if($_POST['action'] == 'cadastrar_palestrante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../login.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$palestrante = new Palestrante();
			$palestranteDAO = new PalestranteDAO();
			$user_login = new UserLogin();
			$user_loginDAO = new UserLoginDAO();

			$palestrante->setName($name);
			$palestrante->setCpf($cpf);
			$palestrante->setEmail($email);
			$palestrante->setEndereco($endereco);
			$palestrante->setNumero($numero);
			$palestrante->setBairro($bairro);
			$palestrante->setEstado($estado);
			$palestrante->setCidade($cidade);
			$palestrante->setCelular($celular);

			$user_login->setName($user_name);
			$user_login->setPassword($password);
			$user_login->setNivel('1');	

			if($palestranteDAO->cadastrarPalestrante($palestrante,$user_login)){
				$user_loginDAO->Login($user_login->getName(),$user_login->getPassword());
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Palestrante!!!";
				header('Location:../login.php');
			}
		}	
	}else if($_POST['action'] == 'consultar_validade_certificado'){
		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		// verifica o nivel do usuario e direciona para a consulta correta de chave do certificado
		if($nivel == '1'){// palestrante
			$palestranteDAO = new PalestranteDAO();

			if($palestranteDAO->verificarValidadeCertificado($chave_validacao_certificado)){
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				header('Location:../validar_certificado.php');
			}else{
				$_SESSION['certificado']['invalido'] = "Certificado Inválido.";
				header('Location:../validar_certificado.php');
			}
		}else if($nivel == '2'){// aluno
			$alunoDAO = new AlunoDAO();

			if($alunoDAO->verificarValidadeCertificado($chave_validacao_certificado)){
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				header('Location:../validar_certificado.php');
			}else{
				$_SESSION['certificado']['invalido'] = "Certificado Inválido.";
				header('Location:../validar_certificado.php');
			}
		}else if($nivel == '3'){// visitante
			$visitanteDAO = new VisitanteDAO();

			if($visitanteDAO->verificarValidadeCertificado($chave_validacao_certificado)){
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				header('Location:../validar_certificado.php');
			}else{
				$_SESSION['certificado']['invalido'] = "Certificado Inválido.";
				header('Location:../validar_certificado.php');
			}
		}
	}else if($_POST['action'] == 'recuperar_senha'){
		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		echo $email;
	}else{
		$_SESSION['msg']['error'] = 'Faça Login';
		header('Location:../login.php');
	}
 ?>