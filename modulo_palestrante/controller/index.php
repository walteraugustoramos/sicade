<?php 
	session_start();

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

		if($palestranteDAO->realizarChamadaPalestrante($id_palestrante,$id_evento,1) && $eventoDAO->setStatusEvento($id_evento,0)){
			$boolean_chamada_aluno = false;
			$boolean_chamada_visitante = false;

			// verifico se existe alunos ou visitantes na lista de chamada	
			if($verifica_aluno == 1 || $verifica_visitante == 1){

				// verifico se existe aluno na lista de chamada
				if($verifica_aluno == 1){
					// faço a chamada dos alunos
					for($i = 0; $i < count($id_aluno); $i++){
						for($j = 0; $j < count($id_aluno); $j++){
							$boolean_chamada_aluno = $alunoDAO->realizarChamadaAluno($id_aluno[$i][$j],$id_evento,$presente[$i][$j]);
						}
					}
				}

				// verifico se existe visitante na lista de chamada
				if($verifica_visitante == 1){
					// faço a chamada dos visitantes
					for($i = 0; $i < count($id_visitante); $i++){
						for($j = 0; $j < count($id_visitante); $j++){
							$boolean_chamada_visitante = $visitanteDAO->realizarChamadaVisitante($id_visitante[$i][$j],$id_evento,$presente[$i][$j]);
						}
					}
				}
			}//fechamento do if($verifica_aluno == 1 || $verifica_visitante == 1)
			
			if($boolean_chamada_aluno == true || $boolean_chamada_visitante == true){
				if($boolean_chamada_aluno == true){
					$_SESSION['msg']['success'] = 'Chamada Realizada com Sucesso!!!';
					header('Location:../index.php');
				}else if($boolean_chamada_visitante == true){
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
		}else{
			$_SESSION['msg']['error'] = 'Falha ao realizar chamada, tente novamente.';
			header('Location:../index.php');
		}
			
	}
 ?>