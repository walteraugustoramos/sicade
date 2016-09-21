<?php 
	session_start();
	include '../../include/config.php';
	include '../model/Administrador.class.php';
	include 'AdministradorDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../model/Palestrante.class.php';
	include 'PalestranteDAO.class.php';
	include '../model/Curso.class.php';
	include 'CursoDAO.class.php';
	include '../model/Visitante.class.php';
	include 'VisitanteDAO.class.php';
	include '../model/Aluno.class.php';
	include 'AlunoDAO.class.php';

	// verifico se existe sessao para o usuario, se não existir sessão redireciono para pagina de login
	if(empty($_SESSION) && isset($_SESSION)){
		$_SESSION['msg']['error'] = 'Faça Login';
		header('Location:../login.php');
	}else if($_POST['action'] == 'cadastrar_administrador'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../form_cadastrar_administrador.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$administrador = new Administrador();
			$administradorDAO = new AdministradorDAO();
			$user_login = new UserLogin();

			$administrador->setName($name);
			$administrador->setCpf($cpf);
			$administrador->setEmail($email);
			$administrador->setEndereco($endereco);
			$administrador->setNumero($numero);
			$administrador->setBairro($bairro);
			$administrador->setEstado($estado);
			$administrador->setCidade($cidade);
			$administrador->setCelular($celular);

			$user_login->setName($user_name);
			$user_login->setPassword($password);
			$user_login->setNivel('0');	

			if($administradorDAO->cadastrarAdministrador($administrador,$user_login)){
				$_SESSION['msg']['success'] = "Funcionario Cadastrado com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Funcionario!!!";
				header("Location:../index.php");
			}
		}	
	}else if($_POST['action'] == 'cadastrar_palestrante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../form_cadastrar_palestrante.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$palestrante = new Palestrante();
			$palestranteDAO = new PalestranteDAO();
			$user_login = new UserLogin();

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
				$_SESSION['msg']['success'] = "Palestrante Cadastrado com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Palestrante!!!";
				header("Location:../index.php");
			}
		}	
	}else if($_POST['action'] == 'cadastrar_curso'){
		foreach ($_POST as $key => $value) {
				$$key = $value;
			}

		$curso = new Curso();
		$cursoDAO = new CursoDAO();

		$curso->setName($nome_curso);

		if($cursoDAO->cadastrarCurso($curso)){
			$_SESSION['msg']['success'] = "Curso Cadastrado com Sucesso!!!";
			header("Location:../index.php");
		}else{
			$_SESSION['msg']['error'] = "Erro ao Cadastrar Curso!!!";
			header("Location:../index.php");
			}
	}else if($_POST['action'] == 'cadastrar_visitante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../form_cadastrar_visitante.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$visitante = new Visitante();
			$visitanteDAO = new VisitanteDAO();
			$user_login = new UserLogin();

			$visitante->setName($name);
			$visitante->setCpf($cpf);
			$visitante->setEmail($email);
			$visitante->setCelular($celular);

			$user_login->setName($user_name);
			$user_login->setPassword($password);
			$user_login->setNivel('3');	

			if($visitanteDAO->cadastrarVisitante($visitante,$user_login)){
				$_SESSION['msg']['success'] = "Visitante Cadastrado com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Visitante!!!";
				header("Location:../index.php");
			}
		}	
	}else if($_POST['action'] == 'cadastrar_aluno'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../form_cadastrar_aluno.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$aluno = new Aluno();
			$alunoDAO = new AlunoDAO();
			$user_login = new UserLogin();

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
				$_SESSION['msg']['success'] = "Aluno Cadastrado com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Aluno!!!";
				header("Location:../index.php");
			}
		}	
	}
 ?>