<?php

	class AlunoDAO{

		public function cadastrarAluno($aluno,$user_login,$id_curso){
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

				$sql = "INSERT INTO aluno(nome, cpf, email, endereco, numero, bairro, estado, cidade, celular, periodo, users_id_user, curso_id_curso) VALUES(:nome, :cpf, :email, :endereco, :numero, :bairro, :estado, :cidade, :celular, :periodo, :users_id_user, :curso_id_curso)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $aluno->getName());
				$statement->bindValue(':cpf', $aluno->getCpf());
				$statement->bindValue(':email', $aluno->getEmail());
				$statement->bindValue(':endereco', $aluno->getEndereco());
				$statement->bindValue(':numero', $aluno->getNumero());
				$statement->bindValue(':bairro', $aluno->getBairro());
				$statement->bindValue(':estado', $aluno->getEstado());
				$statement->bindValue(':cidade', $aluno->getCidade());
				$statement->bindValue(':celular', $aluno->getCelular());
				$statement->bindValue(':periodo', $aluno->getPeriodo());
				$statement->bindValue(':users_id_user', $lastId);
				$statement->bindValue(':curso_id_curso', $id_curso);
				
				$insert_aluno = $statement->execute();

				if($insert_users && $insert_aluno){
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

		public function editarAluno($aluno,$curso){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE aluno SET nome = :nome, email = :email, endereco = :endereco, numero = :numero, bairro = :bairro, estado = :estado, cidade = :cidade, celular = :celular, periodo = :periodo, curso_id_curso = :id_curso WHERE id_aluno = :id_aluno";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $aluno->getName());
				$statement->bindValue(':email', $aluno->getEmail());
				$statement->bindValue(':endereco', $aluno->getEndereco());
				$statement->bindValue(':numero', $aluno->getNumero());
				$statement->bindValue(':bairro', $aluno->getBairro());
				$statement->bindValue(':estado', $aluno->getEstado());
				$statement->bindValue(':cidade', $aluno->getCidade());
				$statement->bindValue(':celular', $aluno->getCelular());
				$statement->bindValue(':periodo', $aluno->getPeriodo());
				$statement->bindValue(':id_curso', $curso);
				$statement->bindValue(':id_aluno', $aluno->getId());
				
				$update_aluno = $statement->execute();

				if($update_aluno){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao editar usuário: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function getAluno($id_user){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM aluno WHERE users_id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_user',$id_user);

				$select_aluno = $statement->execute();

				if($select_aluno){
					if($statement->rowCount() != 0){
						$aluno_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $aluno_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do aluno';
						header('Location:../index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do aluno';
					header('Location:../index.php');
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do aluno: '.$e->getMessage();
				header('Location:../index.php');
			}
		}

		public function inscreverAluno($id_aluno,$id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM aluno_has_evento WHERE aluno_id_aluno = :id_aluno AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_aluno',$id_aluno);
				$statement->bindValue(':id_evento',$id_evento);

				$select_evento = $statement->execute();

				if($select_evento){
					//Se rowCount diferente de zero, aluno já esta inscrito no evento
					if($statement->rowCount() != 0){
						$PDO->rollBack();
						return false;
					}else{// aluno não esta incrito neste evento faço a sua inscrição

						$sql = "INSERT INTO aluno_has_evento(aluno_id_aluno,evento_id_evento,presente) VALUES(:id_aluno, :id_evento, :presente)";

						$statement = $PDO->prepare($sql);

						$statement->bindValue(':id_aluno',$id_aluno);
						$statement->bindValue(':id_evento',$id_evento);
						$statement->bindValue(':presente','0');// por padrão o aluno não está presente até que o palestrante realize a chamada

						$insert_aluno_has_evento = $statement->execute();

						if($insert_aluno_has_evento){
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
				$_SESSION['msg']['error'] = 'Falha ao inscrever o aluno no evento: '.$e->getMessage();
				header('Location:../index.php');	
			}
		}

		// retorna um array com os ids dos dos alunos que se inscreveram no evento
		public function getAlunohasEvento($id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM aluno_has_evento WHERE evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento',$id_evento);

				$select_aluno_has_evento = $statement->execute();

				if($select_aluno_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$aluno_has_evento[] = $evento_dados;
						}
						return $aluno_has_evento;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os alunos inscritos';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os alunos inscritos: '.$e->getMessage();
			}
		}

		public function getAlunoById($id_aluno){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM aluno WHERE id_aluno = :id_aluno";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_aluno',$id_aluno);

				$select_aluno = $statement->execute();

				if($select_aluno){
					if($statement->rowCount() != 0){
						$aluno_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $aluno_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do aluno';
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do aluno';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do aluno: '.$e->getMessage();
			}
		}

		public function realizarChamadaAluno($id_aluno, $id_evento, $presente, $id_palestrante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE aluno_has_evento SET presente = :presente WHERE aluno_id_aluno = :id_aluno AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':presente', $presente);
				$statement->bindValue(':id_aluno', $id_aluno);
				$statement->bindValue(':id_evento', $id_evento);
				
				$update_aluno_has_evento = $statement->execute();

				$sql = "INSERT INTO aluno_certificado(aluno_id_aluno, evento_id_evento, palestrante_id_palestrante, chave_validacao) VALUES(:id_aluno, :id_evento, :id_palestrante, :chave_validacao)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_aluno', $id_aluno);
				$statement->bindValue(':id_evento', $id_evento);
				$statement->bindValue(':id_palestrante', $id_palestrante);
				$statement->bindValue(':chave_validacao', md5(rand()));

				$insert_aluno_certificado = $statement->execute();

				if($update_aluno_has_evento && $insert_aluno_certificado){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao fazer a chamada: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		// retorna um array com os ids dos eventos que o aluno esta inscrito e a presença já foi confirmada pelo palestrante
		public function getEventoAluno($id_aluno, $presente){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM aluno_has_evento WHERE aluno_id_aluno = :id_aluno AND presente = :presente";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_aluno',$id_aluno);
				$statement->bindValue(':presente',$presente);

				$select_aluno_has_evento = $statement->execute();

				if($select_aluno_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$aluno_has_evento[] = $evento_dados;
						}
						return $aluno_has_evento;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o aluno participou.';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o aluno participou: '.$e->getMessage();
			}
		}
	}
 ?>