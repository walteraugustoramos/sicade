<?php

	class AdministradorDAO{

		public function cadastrarAdministrador($administrador,$user_login){
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

				$sql = "INSERT INTO funcionario(nome, cpf, email, endereco, numero, bairro, estado, cidade, celular, users_id_user) VALUES(:nome, :cpf, :email, :endereco, :numero, :bairro, :estado, :cidade, :celular, :users_id_user)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $administrador->getName());
				$statement->bindValue('cpf', $administrador->getCpf());
				$statement->bindValue('email', $administrador->getEmail());
				$statement->bindValue('endereco', $administrador->getEndereco());
				$statement->bindValue('numero', $administrador->getNumero());
				$statement->bindValue('bairro', $administrador->getBairro());
				$statement->bindValue('estado', $administrador->getEstado());
				$statement->bindValue('cidade', $administrador->getCidade());
				$statement->bindValue('celular', $administrador->getCelular());
				$statement->bindValue('users_id_user', $lastId);
				
				$insert_funcionario = $statement->execute();

				if($insert_users && $insert_funcionario){
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