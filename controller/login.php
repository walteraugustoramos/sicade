<?php 
 	session_start();
 	// arquivo que contem as configurações para conexão com banco de dados
 	include '../include/config.php';

 	if(isset($_POST['user_name']) && isset($_POST['password']) && !empty($_POST['user_name']) && !empty($_POST['password'])){

 		foreach ($_POST as $key => $value) {
 			$$key = $value;
 		}

 		$PDO = connection();

 		$sql = 'SELECT *FROM users WHERE user_name = :user_name';

 		$statement = $PDO->prepare($sql);

 		$statement->bindValue(':user_name',$user_name);
 		
 		// executa consulta no banco de dados
 		$statement->execute();

 		// caso a consulta não retornar nenhum resultado redireciona para a pagina de login com uma mensagem de error
 		if($statement->rowCount() != 0){
 			// recupera os dados da consulta
 			$user_dados = $statement->fetch(pdo::FETCH_ASSOC);

 			if(password_verify($password, $user_dados['password'])){
 				// monta a sessão com os dados do usuario
	 			$_SESSION['user']['id'] = $user_dados['id_user'];
	 			$_SESSION['user']['name'] = $user_dados['user_name'];
	 			$_SESSION['user']['password'] = $user_dados['password'];
	 			$_SESSION['user']['nivel'] = $user_dados['nivel'];
	 			header('Location:index.php');
 			}else{
 				$_SESSION['msg']['error'] = 'Usuario ou Senha Incorretos';
 				header('Location:../login.php');
 			}
 		}else{
 			$_SESSION['msg']['error'] = 'Usuario ou Senha Incorretos';
 			header('Location:../login.php');
 		}
 	}else{
 		$_SESSION['msg']['error'] = 'Faça Login';
 		header('Location:../login.php');
 	}
 ?>