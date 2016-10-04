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

		public function editarVisitante($visitante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE visitante SET nome = :nome, email = :email, celular = :celular WHERE id_visitante = :id_visitante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $visitante->getName());
				$statement->bindValue(':email', $visitante->getEmail());
				$statement->bindValue(':celular', $visitante->getCelular());
				$statement->bindValue(':id_visitante', $visitante->getId());
				
				$update_visitante = $statement->execute();

				if($update_visitante){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao editar dados do visitante: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function getVisitante($id_user){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante WHERE users_id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_user',$id_user);

				$select_visitante = $statement->execute();

				if($select_visitante){
					if($statement->rowCount() != 0){
						$visitante_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $visitante_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante';
						header('Location:../index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante';
					header('Location:../index.php');
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante: '.$e->getMessage();
				header('Location:../index.php');
			}
		}

		public function inscreverVisitante($id_visitante,$id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_has_evento WHERE visitante_id_visitante = :id_visitante AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_visitante',$id_visitante);
				$statement->bindValue(':id_evento',$id_evento);

				$select_evento = $statement->execute();

				if($select_evento){
					//Se rowCount diferente de zero, visitante já esta inscrito no evento
					if($statement->rowCount() != 0){
						$PDO->rollBack();
						return false;
					}else{// visitante não esta incrito neste evento faço a sua inscrição

						$sql = "INSERT INTO visitante_has_evento(visitante_id_visitante,evento_id_evento,presente) VALUES(:id_visitante, :id_evento, :presente)";

						$statement = $PDO->prepare($sql);

						$statement->bindValue(':id_visitante',$id_visitante);
						$statement->bindValue(':id_evento',$id_evento);
						$statement->bindValue(':presente','0');// por padrão o visitante não está presente até que o palestrante realize a chamada

						$insert_visitante_has_evento = $statement->execute();

						if($insert_visitante_has_evento){
							$PDO->commit();
							return true;
						}else{
							$PDO->rollBack();
							return false;
						}
					}
				}else{
					$PDO->rollBack();
					return false;
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao inscrever o visitante no evento: '.$e->getMessage();
				header('Location:../index.php');	
			}
		}
	}
 ?>