<?php
	// inclue o arquivo que contem as configurações de conexão com banco de dados
	//include '../../include/config.php';

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
	}
 ?>