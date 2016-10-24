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
	require '../PHPMailer/PHPMailerAutoload.php';
	include '../controller/EventoDAO.class.php';

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
		$palestranteDAO = new PalestranteDAO();
		$eventoDAO = new EventoDAO();
		$alunoDAO = new AlunoDAO();
		$visitanteDAO = new VisitanteDAO();

		// verifica o nivel do usuario e direciona para a consulta correta de chave do certificado
		if($nivel == '1'){// palestrante

			if($palestranteDAO->verificarValidadeCertificado($chave_validacao_certificado) != false){
				$palestrante_certificado = $palestranteDAO->verificarValidadeCertificado($chave_validacao_certificado);
				
				$palestrante = $palestranteDAO->getPalestranteById($palestrante_certificado['palestrante_id_palestrante']);

				$evento = $eventoDAO->getEvento($palestrante_certificado['evento_id_evento'], 0);

				// conversão data
				$evento['data_inicio'] = strftime('%d de %B de %Y', strtotime($evento['data_inicio']));
				// conversão data
				$evento['data_fim'] = strftime('%d de %B de %Y', strtotime($evento['data_fim']));
				
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				$_SESSION['certificado']['evento'] = ucwords($evento['nome']);
				$_SESSION['certificado']['data_inicio'] = $evento['data_inicio'];
				$_SESSION['certificado']['data_fim'] = $evento['data_fim'];
				$_SESSION['certificado']['carga_horaria'] = $evento['carga_horaria'];
				$_SESSION['certificado']['palestrante'] = ucwords($palestrante['nome']);
				$_SESSION['certificado']['participante'] = ucwords($palestrante['nome']);
				$_SESSION['certificado']['chave_validacao'] = $chave_validacao_certificado;
				header('Location:../validar_certificado.php');
			}else{
				$_SESSION['certificado']['invalido'] = "Certificado Inválido.";
				header('Location:../validar_certificado.php');
			}
		}else if($nivel == '2'){// aluno


			if($alunoDAO->verificarValidadeCertificado($chave_validacao_certificado) != false){

				$aluno_certificado = $alunoDAO->verificarValidadeCertificado($chave_validacao_certificado);

				$aluno = $alunoDAO->getAlunoById($aluno_certificado['aluno_id_aluno']);

				$palestrante = $palestranteDAO->getPalestranteById($aluno_certificado['palestrante_id_palestrante']);

				$evento = $eventoDAO->getEvento($aluno_certificado['evento_id_evento'], 0);

				// conversão data
				$evento['data_inicio'] = strftime('%d de %B de %Y', strtotime($evento['data_inicio']));
				// conversão data
				$evento['data_fim'] = strftime('%d de %B de %Y', strtotime($evento['data_fim']));
				
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				$_SESSION['certificado']['evento'] = ucwords($evento['nome']);
				$_SESSION['certificado']['data_inicio'] = $evento['data_inicio'];
				$_SESSION['certificado']['data_fim'] = $evento['data_fim'];
				$_SESSION['certificado']['carga_horaria'] = $evento['carga_horaria'];
				$_SESSION['certificado']['palestrante'] = ucwords($palestrante['nome']);
				$_SESSION['certificado']['participante'] = ucwords($aluno['nome']);
				$_SESSION['certificado']['chave_validacao'] = $chave_validacao_certificado;				
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				header('Location:../validar_certificado.php');
			}else{
				$_SESSION['certificado']['invalido'] = "Certificado Inválido.";
				header('Location:../validar_certificado.php');
			}
		}else if($nivel == '3'){// visitante

			if($visitanteDAO->verificarValidadeCertificado($chave_validacao_certificado) != false){

				$visitante_certificado = $visitanteDAO->verificarValidadeCertificado($chave_validacao_certificado);
				
				$visitante = $visitanteDAO->getVisitanteById($visitante_certificado['visitante_id_visitante']);

				$palestrante = $palestranteDAO->getPalestranteById($visitante_certificado['palestrante_id_palestrante']);

				$evento = $eventoDAO->getEvento($visitante_certificado['evento_id_evento'], 0);

				// conversão data
				$evento['data_inicio'] = strftime('%d de %B de %Y', strtotime($evento['data_inicio']));
				// conversão data
				$evento['data_fim'] = strftime('%d de %B de %Y', strtotime($evento['data_fim']));
				
				$_SESSION['certificado']['valido'] = "Certificado Válido.";
				$_SESSION['certificado']['evento'] = ucwords($evento['nome']);
				$_SESSION['certificado']['data_inicio'] = $evento['data_inicio'];
				$_SESSION['certificado']['data_fim'] = $evento['data_fim'];
				$_SESSION['certificado']['carga_horaria'] = $evento['carga_horaria'];
				$_SESSION['certificado']['palestrante'] = ucwords($palestrante['nome']);
				$_SESSION['certificado']['participante'] = ucwords($visitante['nome']);
				$_SESSION['certificado']['chave_validacao'] = $chave_validacao_certificado;				
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

		$palestranteDAO = new PalestranteDAO();
		$alunoDAO = new AlunoDAO();
		$visitanteDAO = new VisitanteDAO();
		$user_loginDAO = new UserLoginDAO();
		$user_login = new UserLogin();

		// recupera senha palestrante
		if($nivel == '1'){
			// verifico se existe palestrante com o email informado
			if($palestranteDAO->getPalestranteByEmail($email) != false){

				// recupero os dados do palestrante
				$palestrante = $palestranteDAO->getPalestranteByEmail($email);

				// seto o id do palestrante
				$user_login->setId($palestrante['users_id_user']);
				// seto o nome do palestrante
				$user_login->setName($palestrante['nome']);

				// seta o email para onde deve ser enviada a nova senha
				$user_login->setEmail($email);

				// gero a nova senha para o palestrante
				$user_login->setPassword($user_loginDAO->gerarNovaSenha(10,true,true,false));

				// gravo a nova senha no banco de dados
				$user_edit = $user_loginDAO->editarUserLogin($user_login);

				$user_send = $user_loginDAO->sendPasswordForEmail($user_login);

				if($user_edit == true && $user_send == true){
					$_SESSION['msg']['success'] = "Sua nova senha foi enviada para o email: <b>".$email."</b>";
					header('Location:../login.php');	
				}
			}else{
				$_SESSION['msg']['error'] = 'Não existe palestrante com o email informado.';
				header('Location:../login.php');
			}
		}else if($nivel == '2'){// recupera senha aluno
			// verifico se existe aluno com o email informado
			if($alunoDAO->getAlunoByEmail($email) != false){

				// recupero os dados do aluno
				$aluno = $alunoDAO->getAlunoByEmail($email);

				// seto o id do aluno
				$user_login->setId($aluno['users_id_user']);
				// seto o nome do aluno
				$user_login->setName($aluno['nome']);

				// seta o email para onde deve ser enviada a nova senha
				$user_login->setEmail($email);

				// gero a nova senha para o aluno
				$user_login->setPassword($user_loginDAO->gerarNovaSenha(10,true,true,false));

				// gravo a nova senha no banco de dados
				$user_edit = $user_loginDAO->editarUserLogin($user_login);

				$user_send = $user_loginDAO->sendPasswordForEmail($user_login);

				if($user_edit == true && $user_send == true){
					$_SESSION['msg']['success'] = "Sua nova senha foi enviada para o email: <b>".$email."</b>";
					header('Location:../login.php');	
				}
			}else{
				$_SESSION['msg']['error'] = 'Não existe aluno com o email informado.';
				header('Location:../login.php');
			}
		}else if($nivel == '3'){// recupera senha visitante
			// verifico se existe visitante com o email informado
			if($visitanteDAO->getVisitanteByEmail($email) != false){

				// recupero os dados do visitante
				$aluno = $visitanteDAO->getVisitanteByEmail($email);

				// seto o id do visitante
				$user_login->setId($visitante['users_id_user']);
				// seto o nome do visitante
				$user_login->setName($visitante['nome']);

				// seta o email para onde deve ser enviada a nova senha
				$user_login->setEmail($email);

				// gero a nova senha para o aluno
				$user_login->setPassword($user_loginDAO->gerarNovaSenha(10,true,true,false));

				// gravo a nova senha no banco de dados
				$user_edit = $user_loginDAO->editarUserLogin($user_login);

				$user_send = $user_loginDAO->sendPasswordForEmail($user_login);

				if($user_edit == true && $user_send == true){
					$_SESSION['msg']['success'] = "Sua nova senha foi enviada para o email: <b>".$email."</b>";
					header('Location:../login.php');	
				}
			}else{
				$_SESSION['msg']['error'] = 'Não existe visitante com o email informado.';
				header('Location:../login.php');
			}
		}
	}else{
		$_SESSION['msg']['error'] = 'Faça Login';
		header('Location:../login.php');
	}
 ?>