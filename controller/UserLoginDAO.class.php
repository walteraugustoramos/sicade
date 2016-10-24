<?php 
	
	class UserLoginDAO{
		
		public function Login($user_name,$user_password){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = 'SELECT *FROM users WHERE user_name = :user_name AND password = :user_password';

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':user_name',$user_name);
				$statement->bindValue(':user_password',md5($user_password));

				// executa consulta no banco de dados
 				$select_user = $statement->execute();

 				if($select_user){
 					if($statement->rowCount() != 0){
 						// recupera os dados da consulta
 						$user_dados = $statement->fetch(pdo::FETCH_ASSOC);
			 			// monta a sessão com os dados do usuario
				 		$_SESSION['user']['id'] = $user_dados['id_user'];
				 		$_SESSION['user']['name'] = $user_dados['user_name'];
				 		$_SESSION['user']['password'] = $user_dados['password'];
				 		$_SESSION['user']['nivel'] = $user_dados['nivel'];
				 		header('Location:index.php');
 					}else{
 						$_SESSION['msg']['error'] = 'Usuario ou Senha Incorretos';
			 			header('Location:../login.php');
 					}
 				}else{
 					$PDO->rollBack();
 					return false;
 				}
			}catch(pdoexception $e){
				echo 'Falha ao tentar fazer o login do usuario: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function editarUserLogin($user_login){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE users SET password = :password WHERE id_user = :id_user";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':password',md5($user_login->getPassword()));
				$statement->bindValue(':id_user', $user_login->getId());
				
				$update_visitante = $statement->execute();

				if($update_visitante){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				echo 'Falha ao editar senha do visitante: '.$e->getMessage();
				$PDO->rollBack();
			}
		}

		public function gerarNovaSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
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

		// função para envio de senha por email apos alteração 
		// utilizando da biblioteca PHPMailer
		public function sendPasswordForEmail($user_login){

			$name = ucwords($user_login->getName());
			$password = $user_login->getPassword();

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
			$mail->Subject = 'Sua nova senha para sua conta do Sicade.';

			$body = "
					<p>Olá <b>$name</b> tudo bem?</p>
					<p>Sua nova senha para acesso ao Sicade é: <b>$password</b></p>
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