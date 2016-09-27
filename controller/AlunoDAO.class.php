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
	}
 ?>