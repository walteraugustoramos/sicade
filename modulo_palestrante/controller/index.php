<?php 
	session_start();
	define('_MPDF_PATH', '../../mpdf60/');// indica o caminho dos arquivos da biblioteca MPDF
	include(_MPDF_PATH.'mpdf.php');// Inclui o arquivo de configuração da biblioteca MPDF
	include '../../include/config.php';
	include '../../model/Palestrante.class.php';
	include '../../controller/PalestranteDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../controller/UserLoginDAO.class.php';
	include '../../model/Evento.class.php';
	include '../../controller/EventoDAO.class.php';
	include '../../controller/AlunoDAO.class.php';
	include '../../controller/VisitanteDAO.class.php';

	// verifico se existe sessão para o usuario, caso não exista redireciono para a pagina de login
	if(empty($_SESSION['user']['name']) && empty($_SESSION['user']['password'])){
		$_SESSION['msg']['error'] = 'Faça Login';
    	header('Location:../../login.php');
	}else if($_POST['action'] == 'editar_palestrante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_palestrante.php');
		}else{// todos os campos do formulario foram preenchidos executa o else
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}

			$palestrante = new Palestrante();
			$palestranteDAO = new PalestranteDAO();

			$palestrante->setId($id_palestrante);
			$palestrante->setName($name);
			$palestrante->setEmail($email);
			$palestrante->setEndereco($endereco);
			$palestrante->setNumero($numero);
			$palestrante->setBairro($bairro);
			$palestrante->setEstado($estado);
			$palestrante->setCidade($cidade);
			$palestrante->setCelular($celular);

			if($palestranteDAO->editarPalestrante($palestrante)){
				$_SESSION['msg']['success'] = "Dados Editados com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Editar Dados!!!";
				header("Location:../index.php");
			}
		}
	}else if($_POST['action'] == 'editar_senha_palestrante'){
		if(empty($_POST) && isset($_POST)){// verifica se todos os campos foram preenchidos
			$_SESSION['msg']['error'] = 'Preencha todos os campos';
			header('Location:../form_editar_senha_palestrante.php');
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
			$palestranteDAO = new PalestranteDAO();

			$evento->setNome($name);
			$evento->setDescricao($descricao);
			$evento->setDataInicio($eventoDAO->parseDate($data_inicio,'Y-m-d H:i:s'));
			$evento->setDataFim($eventoDAO->parseDate($data_fim,'Y-m-d H:i:s'));
			$evento->setStatus('1');
			$evento->setCargaHoraria($carga_horaria);
			$evento->setQuantidadeVagas($quantidade_vagas);

			// recupera o id do usuario logado
			$user_id = $_SESSION['user']['id'];

			$palestrante = $palestranteDAO->getPalestrante($_SESSION['user']['id']);			
			
			if($eventoDAO->cadastrarEvento($evento,$palestrante['id_palestrante'],$user_id)){
				$_SESSION['msg']['success'] = "Evento Cadastrado com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Cadastrar Evento!!!";
				header("Location:../index.php");
			}
			
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
	}else if($_GET['action'] == 'gerar_certificado'){
		// tratamento para caso as variaveis enviadas via get sejam modificadas na url com valores invalidos
		if(empty($_GET['id_palestrante']) || empty($_GET['id_evento'])){
			$_SESSION['msg']['error'] = 'Erro ao Gerar Certificado.';
			 header('Location:../index.php');
		}else{
			foreach($_GET as $key => $value){
					$$key = $value;
			}
			$palestranteDAO = new PalestranteDAO();
			$palestranteDAO->gerarCertificadoPalestrante($id_palestrante, $id_evento);
		}// fechamento do else
	}
 ?>