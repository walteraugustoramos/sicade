<?php
	// define o local e a timezone para imprimir a data e hora em formato brasileiro
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');

	class VisitanteDAO{

		public function cadastrarVisitante($visitante,$user_login){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "INSERT INTO users(user_name,password,nivel)VALUES(:user_name,:password,:nivel)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':user_name',$user_login->getName());
				$statement->bindValue(':password',md5($user_login->getPassword()));
				$statement->bindValue(':nivel',$user_login->getNivel());

				$insert_users = $statement->execute();

				// recupera o ultimo id do usuario inserido
				$lastId = $PDO->lastInsertId();

				$sql = "INSERT INTO visitante(nome, cpf, email, celular, users_id_user) VALUES(:nome, :cpf, :email, :celular, :users_id_user)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $visitante->getName());
				$statement->bindValue('cpf', $visitante->getCpf());
				$statement->bindValue('email', $visitante->getEmail());
				$statement->bindValue('celular', $visitante->getCelular());
				$statement->bindValue('users_id_user', $lastId);
				
				$insert_visitante = $statement->execute();

				if($insert_users && $insert_visitante){
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

		public function editarVisitante($visitante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE visitante SET nome = :nome, email = :email, celular = :celular WHERE id_visitante = :id_visitante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome', $visitante->getName());
				$statement->bindValue(':email', $visitante->getEmail());
				$statement->bindValue(':celular', $visitante->getCelular());
				$statement->bindValue(':id_visitante', $visitante->getId());
				
				$update_visitante = $statement->execute();

				if($update_visitante){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao editar dados do visitante: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function getVisitante($id_user){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante WHERE users_id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_user',$id_user);

				$select_visitante = $statement->execute();

				if($select_visitante){
					if($statement->rowCount() != 0){
						$visitante_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $visitante_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante';
						header('Location:../index.php');
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante';
					header('Location:../index.php');
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante: '.$e->getMessage();
				header('Location:../index.php');
			}
		}

		public function inscreverVisitante($id_visitante,$id_evento, $numero_inscricao){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_has_evento WHERE visitante_id_visitante = :id_visitante AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_visitante',$id_visitante);
				$statement->bindValue(':id_evento',$id_evento);

				$select_evento = $statement->execute();

				if($select_evento){
					//Se rowCount diferente de zero, visitante já esta inscrito no evento
					if($statement->rowCount() != 0){
						$PDO->rollBack();
						return false;
					}else{// visitante não esta incrito neste evento faço a sua inscrição

						$sql = "INSERT INTO visitante_has_evento(visitante_id_visitante,evento_id_evento,presente,numero_inscricao) VALUES(:id_visitante, :id_evento, :presente, :numero_inscricao)";

						$statement = $PDO->prepare($sql);

						$statement->bindValue(':id_visitante',$id_visitante);
						$statement->bindValue(':id_evento',$id_evento);
						$statement->bindValue(':presente','0');// por padrão o visitante não está presente até que o palestrante realize a chamada
						$statement->bindValue(':numero_inscricao',$numero_inscricao);

						$insert_visitante_has_evento = $statement->execute();

						if($insert_visitante_has_evento){
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
				$_SESSION['msg']['error'] = 'Falha ao inscrever o visitante no evento: '.$e->getMessage();
				header('Location:../index.php');	
			}
		}
		// retorna um array com os ids dos visitantes que se inscreveram no evento
		public function getVisitantehasEvento($id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_has_evento WHERE evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento',$id_evento);

				$select_visitante_has_evento = $statement->execute();

				if($select_visitante_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$visitante_has_evento[] = $evento_dados;
						}
						return $visitante_has_evento;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os visitantes inscritos';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os visitantes inscritos: '.$e->getMessage();
			}
		}

		public function getVisitanteById($id_visitante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante WHERE id_visitante = :id_visitante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_visitante',$id_visitante);

				$select_visitante = $statement->execute();

				if($select_visitante){
					if($statement->rowCount() != 0){
						$visitante_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $visitante_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante.';
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante.';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante: '.$e->getMessage();
			}
		}

		public function realizarChamadaVisitante($id_visitante, $id_evento, $presente, $id_palestrante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE visitante_has_evento SET presente = :presente WHERE visitante_id_visitante = :id_visitante AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':presente', $presente);
				$statement->bindValue(':id_visitante', $id_visitante);
				$statement->bindValue(':id_evento', $id_evento);
				
				$update_visitante_has_evento = $statement->execute();

				$insert_visitante_certificado = true;

				// se presente diferente de zero visitante está presente
				if($presente != 0){
					$sql = "INSERT INTO visitante_certificado(visitante_id_visitante, evento_id_evento, palestrante_id_palestrante, chave_validacao) VALUES(:id_visitante, :id_evento, :id_palestrante, :chave_validacao)";

					$statement = $PDO->prepare($sql);

					$statement->bindValue(':id_visitante', $id_visitante);
					$statement->bindValue(':id_evento', $id_evento);
					$statement->bindValue(':id_palestrante', $id_palestrante);
					$statement->bindValue(':chave_validacao', md5(date('Y-m-d H:i:s').microtime()));

					$insert_visitante_certificado = $statement->execute();
				}


				if($update_visitante_has_evento && $insert_visitante_certificado){
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

		// retorna um array com os ids dos eventos que o visitante esta inscrito e a presença já foi confirmada pelo palestrante
		public function getEventoVisitante($id_visitante, $presente){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_has_evento WHERE visitante_id_visitante = :id_visitante AND presente = :presente";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_visitante',$id_visitante);
				$statement->bindValue(':presente',$presente);

				$select_visitante_has_evento = $statement->execute();

				if($select_visitante_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$visitante_has_evento[] = $evento_dados;
						}
						return $visitante_has_evento;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o visitante participou.';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o visitante participou: '.$e->getMessage();
			}
		}

		public function gerarCertificadoVisitante($id_visitante, $id_evento){
			// retorna um array contendo os dados do visitante
			$visitante = $this->getVisitanteById($id_visitante);

			$eventoDAO = new EventoDAO();
			$palestranteDAO = new PalestranteDAO();

			// retorna um array contendo os dados do evento
			$evento = $eventoDAO->getEvento($id_evento,0);

			if($eventoDAO->parseDate($evento['data_inicio'], 'd/m/Y') < $eventoDAO->parseDate($evento['data_fim'], 'd/m/Y')){
				$complemento = "a ".strftime('%d de %B de %Y', strtotime($evento['data_fim']));
			}else{
				$complemento = "";
			}

			// conversão de data
			$evento['data_inicio'] = strftime('%d de %B de %Y', strtotime($evento['data_inicio']));

			// data que o certificado foi gerado
			$data_certificado_gerado = strftime('%d de %B de %Y as ', strtotime('today'));
			$data_certificado_gerado .= date('H:i:s');

			// data atual do sistema
			$data_atual = strftime('%d de %B de %Y', strtotime('today'));

			// retorna um array contendo o id do palestrante que palestra o evento
			$palestrante_id = $palestranteDAO->getPalestranteByIdEvento($evento['id_evento']);

			// retorna um array contendo os dados do palestrante
			$palestrante = $palestranteDAO->getPalestranteById($palestrante_id['palestrante_id_palestrante']);

			$certificado = $this->getVisitanteHashCertificado($id_visitante, $id_evento, $palestrante_id['palestrante_id_palestrante']);

			// cabeçalho
			header("Content-type: text/html; charset=iso-8859-1");
			// modelo de certificado em html
			$html = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<link rel="shortcut icon" href="../img/favicon.ico" />
			<link rel="icon" type="image/gif" href="../img/animated_favicon1.gif" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

			</head>
			<body>
				<table align="center" width="800" border="0">
					<tr>
						<td align="left"><img src="../../img/rede_doctum.png" border="0" /></td>
					</tr>
					<tr>
						<td align="center"><h3>Certificado</h3></td>
					</tr>
				</table>
				<br/><br />
				<div align="center">
				<table width="800" border="0" align="center" class="certificado">
				  <tr>
					<td>
						<p align="justify" style="color:#000000; font: 20px Verdana, Geneva, sans-serif; padding:0px; font-size: 20px; margin: 0px;">
						Certificamos que <b>'.ucwords($visitante['nome']).'</b> participou do evento <b>'.ucwords($evento['nome']).'</b>, ministrado por <b>'.ucwords($palestrante['nome']).'</b>, realizado em <b>'.$evento['data_inicio'].'</b> <b>'.$complemento.'</b>.Pela institui&ccedil;&atilde;o de ensino <b>Faculdades Unificadas Doctum de Teofilo Otoni</b> com carga hor&aacute;ria de <b>'.$evento['carga_horaria'].'</b> horas.
						</p>
						<br/><br/><br/>
						<p class="certificado">
						<center>Te&oacute;filo Otoni, '.$data_atual.'.</center>
						</p>
					</td>
				  	</tr>
				</table>';

			$tabela = '<table width="800" border="0" align="center" class="certificado">
			<tr>';

			$tabela = $tabela.'</tr>
					</table>
					<p align="center"><big>Chave de Valida&ccedil;&atilde;o: <b>'.$certificado['chave_validacao'].'</b></big></p>
				</div>';

			$html = utf8_encode($html);
			$tabela = utf8_encode($tabela);
			$html = $html.$tabela;

			// cria um novo container PDF no formato A4 com orientação Landscape
			$mpdf=new mPDF('utf-8', 'A4-L');

			// muda o charset para aceitar caracteres acentuados iso UTF-8 utilizados por mim no banco de dados e na geracao do conteudo PHP com HTML
			$mpdf->allow_charset_conversion=true;
			$mpdf->charset_in='UTF-8';

			// modo de visualização
			$mpdf->SetDisplayMode('fullpage');
			
			$mpdf->SetFooter('Verificar Validade do Certificado em: www.sicade.com.br/validar_certificado');
			//bacana este rodape, nao eh mesmo?
			
			//definindo o cabeçalho
			$mpdf->SetHeader('Data do Evento: '.$evento['data_inicio'].' Certificado Gerado em: '.$data_certificado_gerado.'');
			
			// carrega uma folha de estilo - MAGICA!!!
			$stylesheet = file_get_contents('../../css/style_certificado_visitante.css');

			// incorpora a folha de estilo ao PDF
			// O parâmetro 1 diz que este é um css/style e deverá ser interpretado como tal
			$mpdf->WriteHTML($stylesheet,1);

			// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
			$mpdf->WriteHTML($html,2);

			// define um nome para o arquivo PDF
			$arquivo = date("dmyhis").'_certificado.pdf';

			// gera o relatório
			$mpdf->Output($arquivo,'I');			
		}

		// retorna o hash de validação do certificado do visitante
		public function getVisitanteHashCertificado($id_visitante, $id_evento, $id_palestrante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_certificado WHERE visitante_id_visitante = :id_visitante AND evento_id_evento = :id_evento AND palestrante_id_palestrante = :id_palestrante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_visitante',$id_visitante);
				$statement->bindValue(':id_evento',$id_evento);
				$statement->bindValue(':id_palestrante',$id_palestrante);

				$select_visitante_certificado = $statement->execute();

				if($select_visitante_certificado){
					if($statement->rowCount() != 0){
						$visitante_certificado = $statement->fetch(pdo::FETCH_ASSOC);
						return $visitante_certificado;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do visitante.';
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do visitante.';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do visitante: '.$e->getMessage();
			}
		}

		// retorna o true caso a chave informada seja valida
		public function verificarValidadeCertificado($chave_validacao_certificado){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_certificado WHERE chave_validacao = :chave_validacao_certificado";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':chave_validacao_certificado',$chave_validacao_certificado);
				
				$select_visitante_certificado = $statement->execute();

				if($select_visitante_certificado){
					if($statement->rowCount() != 0){
						$visitante_certificado = $statement->fetch(pdo::FETCH_ASSOC);
						return $visitante_certificado;
					}else{
						$PDO->rollBack();
						return false;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do visitante.';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do visitante: '.$e->getMessage();
			}
		}

		// retorna um array com os dados dos visitantes que se inscreveram no evento
		public function getAllVisitanteInscrito($id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT visitante.id_visitante, visitante.nome FROM visitante, visitante_has_evento WHERE visitante_has_evento.visitante_id_visitante = visitante.id_visitante AND visitante_has_evento.evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_evento',$id_evento);

				$select_visitante_has_evento = $statement->execute();

				if($select_visitante_has_evento){
					if($statement->rowCount() != 0){
						while($evento_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$visitante_has_evento[] = $evento_dados;
						}
						return $visitante_has_evento;
					}else{
						$PDO->rollBack();
						return false;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os visitantes inscritos';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os visitantes inscritos: '.$e->getMessage();
			}
		}

		public function getVisitanteByEmail($email){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante WHERE email = :email";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':email',$email);

				$select_aluno = $statement->execute();

				if($select_aluno){
					if($statement->rowCount() != 0){
						$aluno_dados = $statement->fetch(pdo::FETCH_ASSOC);
						return $aluno_dados;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante.';
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante.';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar dados do visitante: '.$e->getMessage();
			}
		}

		public function getVisitantehasEventoById($id_visitante){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM visitante_has_evento WHERE visitante_id_visitante = :id_visitante";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_visitante',$id_visitante);

				$select_visitante_has_evento = $statement->execute();

				if($select_visitante_has_evento){
					if($statement->rowCount() != 0){
						$visitante_has_evento = $statement->fetch(pdo::FETCH_ASSOC);
						return $visitante_has_evento;
					}else{
						$PDO->rollBack();
						return 0;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o visitante participou.';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os eventos que o visitante participou: '.$e->getMessage();
			}
		}
	}
 ?>