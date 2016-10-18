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

		public function getPalestrante($id_user){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante WHERE users_id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_user',$id_user);

				$select_palestrante = $statement->execute();

				if($select_palestrante){
					if($statement->rowCount() != 0){
						$palestrante_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $palestrante_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do palestrante';
						header('Location:../index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do palestrante';
					header('Location:../index.php');
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do palestrante: '.$e->getMessage();
				header('Location:../index.php');
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
				$PDO->rollBack();
				$_SESSION['msg']['error'] = "Erro ao Alterar Dados do Palestrante!!!";
			}
		}

		// retorna um array com os ids dos eventos cadastrados pelo palestrante
		public function getPalestrantehasEvento($id_palestrante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante_has_evento WHERE palestrante_id_palestrante = :id_palestrante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_palestrante',$id_palestrante);

				$select_palestrante_has_evento = $statement->execute();

				if($select_palestrante_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$palestrante_has_evento[] = $evento_dados;
						}
						return $palestrante_has_evento;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar os eventos cadastrados pelo palestrante';
						header('Location:index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os eventos cadastrados pelo palestrante';
					header('Location:index.php');
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os eventos cadastrados pelo palestrante: '.$e->getMessage();
				header('Location:index.php');
			}
		}

		public function realizarChamadaPalestrante($id_palestrante,$id_evento,$presente){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE palestrante_has_evento SET presente = :presente WHERE palestrante_id_palestrante = :id_palestrante AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':presente', $presente);
				$statement->bindValue(':id_palestrante', $id_palestrante);
				$statement->bindValue(':id_evento', $id_evento);
				
				$update_palestrante_has_evento = $statement->execute();

				$sql = "INSERT INTO palestrante_certificado(evento_id_evento, palestrante_id_palestrante, chave_validacao) VALUES(:id_evento, :id_palestrante, :chave_validacao)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento', $id_evento);
				$statement->bindValue(':id_palestrante', $id_palestrante);
				$statement->bindValue(':chave_validacao', md5(rand()));

				$insert_palestrante_certificado = $statement->execute();

				if($update_palestrante_has_evento && $insert_palestrante_certificado){
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

		// retorna um array com os ids dos eventos que o palestrante palestrou
		public function getEventoPalestrante($id_palestrante, $presente){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante_has_evento WHERE palestrante_id_palestrante = :id_palestrante AND presente = :presente";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_palestrante',$id_palestrante);
				$statement->bindValue(':presente',$presente);

				$select_palestrante_has_evento = $statement->execute();

				if($select_palestrante_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$palestrante_has_evento[] = $evento_dados;
						}
						return $palestrante_has_evento;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o palestrante palestrou.';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o palestrante palestrou: '.$e->getMessage();
			}
		}

		// retorna um array com o dados do palestrante que palestra tal evento
		public function getPalestranteByIdEvento($id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante_has_evento WHERE evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento',$id_evento);

				$select_palestrante_has_evento = $statement->execute();

				if($select_palestrante_has_evento){
					if($statement->rowCount() != 0){
						$palestrante_has_evento = $statement->fetch(pdo::FETCH_ASSOC);
						return $palestrante_has_evento;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar os dados do evento cadastrado pelo palestrante';
						header('Location:index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os dados do evento cadastrado pelo palestrante';
					header('Location:index.php');
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os dados do evento cadastrado pelo palestrante: '.$e->getMessage();
				header('Location:index.php');
			}
		}

		public function getPalestranteById($id_palestrante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante WHERE id_palestrante = :id_palestrante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_palestrante',$id_palestrante);

				$select_palestrante = $statement->execute();

				if($select_palestrante){
					if($statement->rowCount() != 0){
						$palestrante_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $palestrante_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do palestrante';
						header('Location:../index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do palestrante';
					header('Location:../index.php');
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do palestrante: '.$e->getMessage();
				header('Location:../index.php');
			}
		}

	}
 ?>