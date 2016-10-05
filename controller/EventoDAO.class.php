<?php

	class EventoDAO{

		public function cadastrarEvento($evento,$palestrante_id,$user_id){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "INSERT INTO evento(nome, descricao, data_inicio, hora_inicio, data_fim, hora_fim, status, carga_horaria)VALUES(:nome, :descricao, :data_inicio, :hora_inicio, :data_fim, :hora_fim, :status, :carga_horaria)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome',$evento->getNome());
				$statement->bindValue(':descricao',$evento->getDescricao());
				$statement->bindValue(':data_inicio',$evento->getDataInicio());
				$statement->bindValue(':hora_inicio',$evento->getHoraInicio());
				$statement->bindValue(':data_fim',$evento->getDataFim());
				$statement->bindValue(':hora_fim',$evento->getHoraFim());
				$statement->bindValue(':status',$evento->getStatus());
				$statement->bindValue(':carga_horaria',$evento->getCargaHoraria());

				$insert_evento = $statement->execute();
				
				// recupera o ultimo id do evento inserido
				$lastId = $PDO->lastInsertId();

				$sql = "INSERT INTO palestrante_has_evento(palestrante_id_palestrante, evento_id_evento)VALUES(:palestrante_id_palestrante, :evento_id_evento)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':palestrante_id_palestrante',$palestrante_id);
				$statement->bindValue(':evento_id_evento',$lastId);

				$insert_palestrante_has_evento = $statement->execute();
				
				if($insert_evento && $insert_palestrante_has_evento){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				return 'Falha ao cadastrar evento: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function getEvento($id_evento){
			$PDO = connection();

			try{
				$PDO->beginTransaction();

				$sql = "SELECT *FROM evento WHERE id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento',$id_evento);

				$select_evento = $statement->execute();

				if($select_evento){
					if($statement->rowCount() != 0){
						$PDO->commit();
						$evento_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $evento_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os eventos cadastrados pelo palestrante';
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os eventos cadastrados pelo palestrante';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os eventos cadastrados pelo palestrante: '.$e->getMessage();
			}
		}

		public function editarEvento($evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE evento SET nome = :nome, descricao = :descricao, data_inicio = :data_inicio, hora_inicio = :hora_inicio, data_fim = :data_fim, hora_fim = :hora_fim, status = :status, carga_horaria = :carga_horaria WHERE id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome',$evento->getNome());
				$statement->bindValue(':descricao',$evento->getDescricao());
				$statement->bindValue(':data_inicio',$evento->getDataInicio());
				$statement->bindValue(':hora_inicio',$evento->getHoraInicio());
				$statement->bindValue(':data_fim',$evento->getDataFim());
				$statement->bindValue(':hora_fim',$evento->getHoraFim());
				$statement->bindValue(':status',$evento->getStatus());
				$statement->bindValue(':carga_horaria',$evento->getCargaHoraria());
				$statement->bindValue(':id_evento',$evento->getIdEvento());

				$update_evento = $statement->execute();

				if($update_evento){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao editar dados do evento: '.$e->getMessage();
			}


		}
	}
 ?>