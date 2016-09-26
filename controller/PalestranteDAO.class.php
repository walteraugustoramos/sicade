<?php
	// inclue o arquivo que contem as configurações de conexão com banco de dados
	//include '../../include/config.php';

	class PalestranteDAO{

		public function cadastrarPalestrante($palestrante,$user_login){
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

				$sql = "INSERT INTO palestrante(nome, cpf, email, endereco, numero, bairro, estado, cidade, celular, users_id_user) VALUES(:nome, :cpf, :email, :endereco, :numero, :bairro, :estado, :cidade, :celular, :users_id_user)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $palestrante->getName());
				$statement->bindValue('cpf', $palestrante->getCpf());
				$statement->bindValue('email', $palestrante->getEmail());
				$statement->bindValue('endereco', $palestrante->getEndereco());
				$statement->bindValue('numero', $palestrante->getNumero());
				$statement->bindValue('bairro', $palestrante->getBairro());
				$statement->bindValue('estado', $palestrante->getEstado());
				$statement->bindValue('cidade', $palestrante->getCidade());
				$statement->bindValue('celular', $palestrante->getCelular());
				$statement->bindValue('users_id_user', $lastId);
				
				$insert_palestrante = $statement->execute();

				if($insert_users && $insert_palestrante){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao cadastrar usuário: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function editarPalestrante($palestrante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE palestrante SET nome = :nome, email = :email, endereco = :endereco, numero = :numero, bairro = :bairro, estado = :estado, cidade = :cidade, celular = :celular WHERE id_palestrante = :id_palestrante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $palestrante->getName());
				$statement->bindValue('email', $palestrante->getEmail());
				$statement->bindValue('endereco', $palestrante->getEndereco());
				$statement->bindValue('numero', $palestrante->getNumero());
				$statement->bindValue('bairro', $palestrante->getBairro());
				$statement->bindValue('estado', $palestrante->getEstado());
				$statement->bindValue('cidade', $palestrante->getCidade());
				$statement->bindValue('celular', $palestrante->getCelular());
				$statement->bindValue('id_palestrante', $palestrante->getId());
				
				$update_palestrante = $statement->execute();

				if($update_palestrante){
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