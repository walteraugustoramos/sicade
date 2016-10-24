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

		public function gerarNumeroInscricao($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
			// Caracteres de cada tipo
			$lmin = 'abcdefghijklmnopqrstuvwxyz';
			$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$num = '1234567890';
			$simb = '!@#$%*-';
			// Variáveis internas
			$retorno = '';
			$caracteres = '';
			// Agrupamos todos os caracteres que poderão ser utilizados
			$caracteres .= $lmin;
			if ($maiusculas) $caracteres .= $lmai;
			if ($numeros) $caracteres .= $num;
			if ($simbolos) $caracteres .= $simb;
			// Calculamos o total de caracteres possíveis
			$len = strlen($caracteres);
			for ($n = 1; $n <= $tamanho; $n++) {
			// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
			$rand = mt_rand(1, $len);
			// Concatenamos um dos caracteres na variável $retorno
			$retorno .= $caracteres[$rand-1];
			}
			return $retorno;
		}

		// função para envio de numero de inscrição por email apos inscrição no evento 
		// utilizando da biblioteca PHPMailer
		public function sendNumeroInscricaoForEmail($user_login, $nome_evento){

			$name = ucwords($user_login->getName());
			$numero_inscricao = $user_login->getNumeroInscricao();
			$nome_evento = ucwords($nome_evento);

			// Instância do objeto PHPMailer
			$mail = new PHPMailer;

			// Configura para envio de e-mails usando SMTP
			$mail->isSMTP();

			// To load the French version
			$mail->setLanguage('fr', '../PHPMailer/language/phpmailer.lang-br.php');

			// Servidor SMTP
			$mail->Host = 'smtp.gmail.com';

			// Usar autenticação SMTP
			$mail->SMTPAuth = true;

			// Usuário da conta
			$mail->Username = 'sicadedoctum@gmail.com';

			// Senha da conta
			$mail->Password = 'sicadedoctum2016';

			// Tipo de encriptação que será usado na conexão SMTP
			$mail->SMTPSecure = 'ssl';

			// Porta do servidor SMTP
			$mail->Port = 465;

			// Informa se vamos enviar mensagens usando HTML
			$mail->IsHTML(true);

			// defino o charset para evitar problemas de acentuação
			$mail->CharSet = 'UTF-8';

			// Email do Remetente
			$mail->From = 'sicadedoctum@gmail.com';

			// Nome do Remetente
			$mail->FromName = 'Sicade';

			// email e nome para resposta
			$mail->addReplyTo('sicadedoctum@gmail.com', 'Sicade');

			// Endereço do e-mail do destinatário
			$mail->addAddress($user_login->getEmail());

			// Assunto do e-mail
			$mail->Subject = "Seu numero de inscrição para o Evento $nome_evento";

			$body = "
					<p>Olá <b>$name</b> tudo bem?</p>
					<p>Guarde bem o seu numero de inscrição, ele será necessário para confirmar a sua participação no evento <b>$nome_evento</b></p>
					<p>Seu numero de inscrição: <b>$numero_inscricao</b></p>
					</br></br></br></br><center><p>Sicade - Sistema Integrado de Cadastro de Eventos</p></center>
					<center><p>www.sicade.com.br</p></center>
					<center><p>sicadedoctum@gmail.com</p></center>";
				
			// Mensagem que vai no corpo do e-mail
			$mail->Body = $body;

			// Envia o e-mail e retorna true em caso de sucesso ou exibe uma mensagem com o erro
			if($mail->Send()){
				return true;
			}else{
				$_SESSION['msg']['error'] = 'Falha ao enviar email: '.$mail->ErrorInfo;
			}
		}
	}
 ?>