<?php 
	session_start();

	include '../../include/config.php';
	include '../../model/Palestrante.class.php';
	include '../../controller/PalestranteDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../controller/UserLoginDAO.class.php';
	include '../../model/Evento.class.php';
	include '../../controller/EventoDAO.class.php';

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

			// formato a data para o padrao aceito pelo mysql
			$data_inicio = implode("-",array_reverse(explode("/",$data_inicio)));
			$data_fim = implode("-",array_reverse(explode("/",$data_fim)));

			$evento->setNome($name);
			$evento->setDescricao($descricao);
			$evento->setDataInicio($data_inicio);
			$evento->setHoraInicio($hora_inicio.':00');// formato a hora para o padrao aceito pelo mysql
			$evento->setDataFim($data_fim);
			$evento->setHoraFim($hora_fim.':00');// formato a hora para o padrao aceito pelo mysql
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

			// formato a data para o padrao aceito pelo mysql
			$data_inicio = implode("-",array_reverse(explode("/",$data_inicio)));
			$data_fim = implode("-",array_reverse(explode("/",$data_fim)));

			$evento->setIdEvento($id_evento);
			$evento->setNome($name);
			$evento->setDescricao($descricao);
			$evento->setDataInicio($data_inicio);
			$evento->setHoraInicio($hora_inicio.':00');// formato a hora para o padrao aceito pelo mysql
			$evento->setDataFim($data_fim);
			$evento->setHoraFim($hora_fim.':00');// formato a hora para o padrao aceito pelo mysql
			$evento->setStatus('1');
			$evento->setCargaHoraria($carga_horaria);			
			
			if($eventoDAO->editarEvento($evento)){
				$_SESSION['msg']['success'] = "Dados do Evento Alterados Com Sucesso!!!";
				header("Location:../index.php");
			}else{
				$_SESSION['msg']['error'] = "Erro ao Alterar Dados do Evento!!!";
				header("Location:../index.php");
			}
			
		}	
	}
 ?>