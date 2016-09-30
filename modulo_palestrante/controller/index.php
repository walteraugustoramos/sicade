<?php 
	session_start();

	include '../../include/config.php';
	include '../../model/Palestrante.class.php';
	include '../../controller/PalestranteDAO.class.php';
	include '../../model/UserLogin.class.php';
	include '../../controller/UserLoginDAO.class.php';

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
	}
 ?>