<?php

	class VisitanteDAO{

		public function cadastrarVisitante($visitante,$user_login){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "INSERT INTO users(user_name,password,nivel)VALUES(:user_name,:password,:nivel)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':user_name',$user_login->getName());
				$statement->bindValue(':password',password_hash($user_login->getPassword(),PASSWORD_DEFAULT));
				$statement->bindValue(':nivel',$user_login->getNivel());

				$insert_users = $statement->execute();

				// recupera o ultimo id do usuario inserido
				$lastId = $PDO->lastInsertId();

				$sql = "INSERT INTO visitante(nome, cpf, email, celular, users_id_user) VALUES(:nome, :cpf, :email, :celular, :users_id_user)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $visitante->getName());
				$statement->bindValue('cpf', $visitante->getCpf());
				$statement->bindValue('email', $visitante->getEmail());
				$statement->bindValue('celular', $visitante->getCelular());
				$statement->bindValue('users_id_user', $lastId);
				
				$insert_visitante = $statement->execute();

				if($insert_users && $insert_visitante){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				return 'Falha ao cadastrar usuário: '.$e->getMessage();
				$PDO->rollBack();
			}
		}
	}
 ?>