<?php
	// define o local e a timezone para imprimir a data e hora em formato brasileiro
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');

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
				$statement->bindValue(':chave_validacao', md5(date('Y-m-d H:i:s').microtime()));

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

		public function gerarCertificadoPalestrante($id_palestrante, $id_evento){
			// retorna um array contendo os dados do palestrante
			$palestrante = $this->getPalestranteById($id_palestrante);

			$eventoDAO = new EventoDAO();

			// retorna um array contendo os dados do evento
			$evento = $eventoDAO->getEvento($id_evento,0);

			// conversão de data
			$evento['data_inicio'] = strftime('%d de %B de %Y', strtotime($evento['data_inicio']));

			// data que o certificado foi gerado
			$data_certificado_gerado = strftime('%d de %B de %Y as ', strtotime('today'));
			$data_certificado_gerado .= date('H:i:s');

			// data atual do sistema
			$data_atual = strftime('%d de %B de %Y', strtotime('today'));

			$certificado = $this->getPalestranteHashCertificado($id_palestrante, $id_evento);

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
						Conferimos a <b>'.ucwords($palestrante['nome']).'</b> o presente certificado por ter ministrado o evento <b>'.ucwords($evento['nome']).'</b>, realizado em <b>'.$evento['data_inicio'].'</b>.Pela institui&ccedil;&atilde;o de ensino <b>Faculdades Unificadas Doctum de Teofilo Otoni</b> com carga hor&aacute;ria de <b>'.$evento['carga_horaria'].'</b> horas.
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
			$stylesheet = file_get_contents('../../css/style_certificado_palestrante.css');

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

		// retorna o hash de validação do certificado do palestrante
		public function getPalestranteHashCertificado($id_palestrante, $id_evento){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante_certificado WHERE palestrante_id_palestrante = :id_palestrante AND evento_id_evento = :id_evento";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':id_palestrante',$id_palestrante);
				$statement->bindValue(':id_evento',$id_evento);
				
				$select_palestrante_certificado = $statement->execute();

				if($select_palestrante_certificado){
					if($statement->rowCount() != 0){
						$palestrante_certificado = $statement->fetch(pdo::FETCH_ASSOC);
						return $palestrante_certificado;
					}else{
						$PDO->rollBack();
						$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do palestrante.';
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do palestrante.';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do palestrante: '.$e->getMessage();
			}
		}

		// retorna o true caso a chave informada seja valida
		public function verificarValidadeCertificado($chave_validacao_certificado){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "SELECT *FROM palestrante_certificado WHERE chave_validacao = :chave_validacao_certificado";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':chave_validacao_certificado',$chave_validacao_certificado);
				
				$select_palestrante_certificado = $statement->execute();

				if($select_palestrante_certificado){
					if($statement->rowCount() != 0){
						$palestrante_certificado = $statement->fetch(pdo::FETCH_ASSOC);
						//return $palestrante_certificado;
						$PDO->rollBack();
						return true;
					}else{
						$PDO->rollBack();
						return false;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do palestrante.';
				}
			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar os dados do certificado do palestrante: '.$e->getMessage();
			}
		}
	}
 ?>