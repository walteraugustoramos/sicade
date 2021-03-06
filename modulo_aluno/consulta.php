<?php
session_start(); 
// Dados da conexão com o banco de dados
define('SERVER', 'localhost');
define('DBNAME', 'bd_sicade');
define('USER', 'root');
define('PASSWORD', '');

// Recebe os parâmetros enviados via GET
$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? $_GET['parametro'] : '';

// Configura uma conexão com o banco de dados
//$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$conexao = new PDO("mysql:host=".SERVER."; dbname=".DBNAME, USER, PASSWORD);

// Verifica se foi solicitado uma consulta para o autocomplete
if($acao == 'autocomplete'):
	$where = (!empty($parametro)) ? 'WHERE nome LIKE ? AND status != 0 AND quantidade_inscritos < quantidade_vagas' : '';
	$sql = "SELECT id_evento, nome, descricao FROM evento " . $where;

	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, '%'.$parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
	echo $json;
endif;

// Verifica se foi solicitado uma consulta para preencher os campos do formulário
if($acao == 'consulta'):
	$sql = "SELECT id_evento, nome, carga_horaria, quantidade_vagas, quantidade_inscritos, date_format(`data_inicio`,'%d de %M às %Hh%i')
 AS data_inicio FROM evento ";
	$sql .= "WHERE nome LIKE ? LIMIT 1";

	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
	echo $json;
endif;