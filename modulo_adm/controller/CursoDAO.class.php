<?php
	// inclue o arquivo que contem as configurações de conexão com banco de dados
	//include '../../include/config.php';

	class CursoDAO{

		public function cadastrarCurso($curso){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "INSERT INTO curso(nome)VALUES(:nome)";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':nome',$curso->getName());

				$insert_curso = $statement->execute();


				if($insert_curso){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				return 'Falha ao cadastrar curso: '.$e->getMessage();
				$PDO->rollBack();
			}
		}
	}
 ?>