<?php 
	session_start();
	include '../../include/config.php';
	include '../../model/Administrador.class.php';
	include 'AdministradorDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../model/Palestrante.class.php';
	include '../../controller/PalestranteDAO.class.php';
	include '../../model/Curso.class.php';
	include '../../controller/CursoDAO.class.php';
	include '../../model/Visitante.class.php';
	include '../../controller/VisitanteDAO.class.php';
	include '../../model/Aluno.class.php';
	include '../../controller/AlunoDAO.class.php';
	include '../../model/Evento.class.php';
	include '../../controller/EventoDAO.class.php';
	include '../../controller/UserLoginDAO.class.php';

	// verifico se existe sessão para o usuario, caso não exista redireciono para a pagina de login
	if(empty($_SESSION['user']['name']) && empty($_SESSION['user']['password'])){
		$_SESSION['msg']['error'] = 'Faça Login';
    	header('Location:../../login.php');
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
	}else if($_POST['action'] == 'editar_curso'){
		foreach ($_POST as $key => $value) {
			$$key = $value;
		}
		$cursoDAO = new CursoDAO();

		
		if($cursoDAO->editarCurso($curso_name, $id_curso) != false){
			$_SESSION['msg']['success'] = "Curso editado com Sucesso!!!";
			header("Location:../curso.php");
		}else{
			$_SESSION['msg']['error'] = "Erro ao editar Curso!!!";
			header("Location:../curso.php");
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
	}else if($_POST['action'] == 'cadastrar_evento'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../form_cadastrar_evento.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$evento = new Evento();
			$eventoDAO = new EventoDAO();

			$evento->setNome($name);
			$evento->setDescricao($descricao);
			$evento->setDataInicio($eventoDAO->parseDate($data_inicio,'Y-m-d H:i:s'));
			$evento->setDataFim($eventoDAO->parseDate($data_fim,'Y-m-d H:i:s'));
			$evento->setStatus('1');
			$evento->setCargaHoraria($carga_horaria);
			$evento->setQuantidadeVagas($quantidade_vagas);

			// recupera o id do usuario logado
			$user_id = $_SESSION['user']['id'];
			
			if($eventoDAO->cadastrarEvento($evento,$palestrante_id,$user_id)){
				$_SESSION['msg']['success'] = "Evento Cadastrado com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Evento!!!";
				header("Location:../index.php");
			}
			
		}	
	}else if($_POST['action'] == 'realizar_chamada'){

		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		$alunoDAO = new alunoDAO();
		$palestranteDAO = new PalestranteDAO();
		$eventoDAO = new EventoDAO();
		$visitanteDAO = new VisitanteDAO();

		$boolean_chamada_aluno = false;
		$boolean_chamada_visitante = false;

		// realizo chamada do palestrante e mudo o status do evento
		if($palestranteDAO->realizarChamadaPalestrante($id_palestrante,$id_evento,1) && $eventoDAO->setStatusEvento($id_evento,0)){

			if($quantidade_visitantes > 0){

				// faço a chamada para os visitantes inscritos
				for($i = 0, $j = 0; $i < $quantidade_visitantes; $i++){
					$boolean_chamada_visitante = $visitanteDAO->realizarChamadaVisitante($id_visitante[$i][$j], $id_evento, $presenca_visitante[$i][$j], $id_palestrante);
				}
			}

			if($quantidade_visitantes > 0){

				// faço a chamada para os alunos inscritos
				for($i = 0, $j = 0; $i < $quantidade_alunos; $i++){
					$boolean_chamada_aluno = $alunoDAO->realizarChamadaAluno($id_aluno[$i][$j], $id_evento, $presenca_aluno[$i][$j], $id_palestrante);
				}
			}

			if($boolean_chamada_aluno == true || $boolean_chamada_visitante == true){
				$_SESSION['msg']['success'] = 'Chamada Realizada com Sucesso!!!';
				header('Location:../index.php');
			}else{
				$_SESSION['msg']['error'] = 'Falha ao realizar chamada, tente novamente.';
				header('Location:../index.php');
			}
		}else{
			$_SESSION['msg']['error'] = 'Falha ao realizar chamada, tente novamente.';
			header('Location:../index.php');
		}
	}else if($_POST['action'] == 'editar_evento'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos.';
			header('Location:../form_cadastrar_evento.php');
		}else{// todos os campos do formulario preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$evento = new Evento();
			$eventoDAO = new EventoDAO();

			$evento->setIdEvento($id_evento);
			$evento->setNome($name);
			$evento->setDescricao($descricao);
			$evento->setDataInicio($eventoDAO->parseDate($data_inicio,'Y-m-d H:i:s'));
			$evento->setDataFim($eventoDAO->parseDate($data_fim,'Y-m-d H:i:s'));
			$evento->setStatus('1');
			$evento->setCargaHoraria($carga_horaria);
			$evento->setQuantidadeVagas($quantidade_vagas);		
			
			if($eventoDAO->editarEvento($evento)){
				$_SESSION['msg']['success'] = 'Dados do Evento Alterados Com Sucesso!!!';
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = 'Erro ao Alterar Dados do Evento!!!';
				header("Location:../index.php");
			}
		}	
	}else if($_POST['action'] == 'editar_funcionario'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_administrador.php');
		}else{// todos os campos do formulario foram preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$administrador = new Administrador();
			$administradorDAO = new AdministradorDAO();

			$administrador->setId($id_funcionario);
			$administrador->setName($name);
			$administrador->setEmail($email);
			$administrador->setEndereco($endereco);
			$administrador->setNumero($numero);
			$administrador->setBairro($bairro);
			$administrador->setEstado($estado);
			$administrador->setCidade($cidade);
			$administrador->setCelular($celular);

			if($administradorDAO->editarAdministrador($administrador)){
				$_SESSION['msg']['success'] = "Dados Editados com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Editar Dados!!!";
				header("Location:../index.php");
			}
		}
	}else if($_POST['action'] == 'editar_senha_administrador'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_senha_administrador.php');
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
	}
 ?>