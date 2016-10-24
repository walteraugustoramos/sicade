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

		public function getAllCurso(){
			$PDO = connection();

			try{
				$PDO->beginTransaction();

				$sql = "SELECT *FROM curso";

				$statement = $PDO->prepare($sql);

				$select_curso = $statement->execute();

				if($select_curso){
					if($statement->rowCount() != 0){
						while($curso_dados = $statement->fetch(pdo::FETCH_ASSOC)){
							$cursos[] = $curso_dados;
						}
						$PDO->commit();
						return $cursos;
					}else{
						$PDO->rollBack();
						return false;
					}
				}else{
					$PDO->rollBack();
					$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os cursos.';
				}

			}catch(pdoexception $e){
				$PDO->rollBack();
				$_SESSION['msg']['error'] = 'Falha ao consultar informações sobre os cursos: '.$e->getMessage();
			}
		}

		public function editarCurso($curso_name, $curso_id){
			$PDO = connection();

			try{
				// inicia a transação
				$PDO->beginTransaction();

				$sql = "UPDATE curso SET nome = :curso_name WHERE id_curso = :curso_id";

				$statement = $PDO->prepare($sql);

				$statement->bindValue(':curso_name',$curso_name);
				$statement->bindValue(':curso_id',$curso_id);

				$update_curso = $statement->execute();

				if($update_curso){
					$PDO->commit();
					return true;
				}else{
					$PDO->rollBack();
					return false;
				}

			}catch(pdoexception $e){
				return 'Falha ao editar curso: '.$e->getMessage();
				$PDO->rollBack();
			}
		}
	}
 ?>