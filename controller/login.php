<?php 
 	session_start();
 	// arquivo que contem as configurações para conexão com banco de dados
 	include '../include/config.php';
 	include 'UserLoginDAO.class.php';

 	if(isset($_POST['user_name']) && isset($_POST['password']) && !empty($_POST['user_name']) && !empty($_POST['password'])){

 		foreach ($_POST as $key => $value) {
 			$$key = $value;
 		}

 		$user_loginDAO = new UserLoginDAO();

 		$user_loginDAO->Login($user_name,$password);
 		
 	}else{
 		$_SESSION['msg']['error'] = 'Faça Login';
 		header('Location:../login.php');
 	}
 ?>