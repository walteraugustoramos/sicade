<?php 
	
	class UserLoginDAO{
		
		public function Login($user_name,$user_password){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = 'SELECT *FROM users WHERE user_name = :user_name AND password = :user_password';

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':user_name',$user_name);
				$statement->bindValue(':user_password',md5($user_password));

				// executa consulta no banco de dados
 				$select_user = $statement->execute();

 				if($select_user){
 					if($statement->rowCount() != 0){
 						// recupera os dados da consulta
 						$user_dados = $statement->fetch(pdo::FETCH_ASSOC);
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
 					$PDO->rollBack();
 					return false;
 				}
			}catch(pdoexception $e){
				echo 'Falha ao tentar fazer o login do usuario: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function editarUserLogin($user_login){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE users SET password = :password WHERE id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':password',md5($user_login->getPassword()));
				$statement->bindValue(':id_user', $user_login->getId());
				
				$update_visitante = $statement->execute();

				if($update_visitante){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao editar senha do visitante: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function gerarNovaSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
			// Caracteres de cada tipo
			$lmin = 'abcdefghijklmnopqrstuvwxyz';
			$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$num = '1234567890';
			$simb = '!@#$%*-';
			// Variáveis internas
			$retorno = '';
			$caracteres = '';
			// Agrupamos todos os caracteres que poderão ser utilizados
			$caracteres .= $lmin;
			if ($maiusculas) $caracteres .= $lmai;
			if ($numeros) $caracteres .= $num;
			if ($simbolos) $caracteres .= $simb;
			// Calculamos o total de caracteres possíveis
			$len = strlen($caracteres);
			for ($n = 1; $n <= $tamanho; $n++) {
			// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
			$rand = mt_rand(1, $len);
			// Concatenamos um dos caracteres na variável $retorno
			$retorno .= $caracteres[$rand-1];
			}
			return $retorno;
		}	
	}
 ?>