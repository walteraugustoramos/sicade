<?php

	class EventoDAO{

		public function cadastrarEvento($evento,$palestrante_id,$user_id){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "INSERT INTO evento(nome, descricao, data_inicio, data_fim, status, carga_horaria, quantidade_vagas)VALUES(:nome, :descricao, :data_inicio, :data_fim, :status, :carga_horaria, :quantidade_vagas)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome',$evento->getNome());
				$statement->bindValue(':descricao',$evento->getDescricao());
				$statement->bindValue(':data_inicio',$evento->getDataInicio());
				$statement->bindValue(':data_fim',$evento->getDataFim());
				$statement->bindValue(':status',$evento->getStatus());
				$statement->bindValue(':carga_horaria',$evento->getCargaHoraria());
				$statement->bindValue(':quantidade_vagas',$evento->getQuantidadeVagas());

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

		public function getEvento($id_evento,$status){
			$PDO = connection();

			try{
				$PDO->beginTransaction();

				$sql = "SELECT *FROM evento WHERE id_evento = :id_evento AND status = :status";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento',$id_evento);
				$statement->bindValue(':status',$status);

				$select_evento = $statement->execute();

				if($select_evento){
					if($statement->rowCount() != 0){
						$PDO->commit();
						$evento_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $evento_dados;
					}else{
						$PDO->rollBack();
						return 0;
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

				$sql = "UPDATE evento SET nome = :nome, descricao = :descricao, data_inicio = :data_inicio, data_fim = :data_fim, status = :status, carga_horaria = :carga_horaria, quantidade_vagas = :quantidade_vagas WHERE id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome',$evento->getNome());
				$statement->bindValue(':descricao',$evento->getDescricao());
				$statement->bindValue(':data_inicio',$evento->getDataInicio());
				$statement->bindValue(':data_fim',$evento->getDataFim());
				$statement->bindValue(':status',$evento->getStatus());
				$statement->bindValue(':carga_horaria',$evento->getCargaHoraria());
				$statement->bindValue(':quantidade_vagas',$evento->getQuantidadeVagas());
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

		public function setStatusEvento($id_evento,$status){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE evento SET status = :status WHERE id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':status',$status);
				$statement->bindValue(':id_evento',$id_evento);

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

		// incrementa a quantidade de inscritos
		public function setQuantidadeInscritosEvento($id_evento,$quantidade_inscritos){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE evento SET quantidade_inscritos = :quantidade_inscritos WHERE id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':quantidade_inscritos',$quantidade_inscritos);
				$statement->bindValue(':id_evento',$id_evento);

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
				$_SESSION['msg']['error'] = 'Falha ao incrementar a quantidade de inscritos do evento: '.$e->getMessage();
			}
		}

		// função converte a data para o formato desejado
		public function parseDate($date, $outputFormat){
		    $formats = array(
		        'd/m/Y',
		        'd/m/Y H',
		        'd/m/Y H:i',
		        'd/m/Y H:i:s',
		        'Y-m-d',
		        'Y-m-d H',
		        'Y-m-d H:i',
		        'Y-m-d H:i:s',
		    );

		    foreach($formats as $format){
		        $dateObj = DateTime::createFromFormat($format, $date);
		        if($dateObj !== false){
		            break;
		        }
		    }

		    if($dateObj === false){
		        throw new Exception('Invalid date:' . $date);
		    }

		    return $dateObj->format($outputFormat);
		}

		public function getAllEvento($status){
			$PDO = connection();

			try{
				$PDO->beginTransaction();

				$sql = "SELECT *FROM evento WHERE status = :status";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':status',$status);

				$select_evento = $statement->execute();

				if($select_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$eventos[] = $evento_dados;
						}
						$PDO->commit();
						return $eventos;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os eventos.';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os eventos: '.$e->getMessage();
			}
		}
	}
 ?>