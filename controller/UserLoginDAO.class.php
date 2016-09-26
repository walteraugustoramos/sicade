<?php 

	class UserLoginDAO{
		public function editarUserLogin($user_login){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE users SET password = :password WHERE id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':password',password_hash($user_login->getPassword(),PASSWORD_DEFAULT));
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
	}
 ?>