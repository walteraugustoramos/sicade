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
				
				// execulta um consulta no banco de dados e recupera o id do funcionario
				$sql = "SELECT *FROM funcionario WHERE users_id_user = :user_id";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':user_id',$user_id);

				$select_funcionario_id_administrador = $statement->execute();

				if($statement->rowCount() != 0){
					$funcionario_dados = $statement->fetch(pdo::FETCH_ASSOC);
					$funcionario_id = $funcionario_dados['id_administrador'];
				}

				$sql = "INSERT INTO funcionario_has_evento(funcionario_id_administrador, evento_id_evento)VALUES(:funcionario_id_administrador, :evento_id_evento)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':funcionario_id_administrador',$funcionario_id);
				$statement->bindValue(':evento_id_evento',$lastId);

				$insert_funcionario_id_administrador = $statement->execute();
				
				if($insert_evento && $insert_palestrante_has_evento && $select_funcionario_id_administrador && $insert_funcionario_id_administrador){
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