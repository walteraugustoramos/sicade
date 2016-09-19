<?php 
	define('MYSQL_HOST', 'localhost');
	define('MYSQL_USER', 'root');
	define('MYSQL_PASSWORD', '');
	define('MYSQL_DB_NAME', 'bd_sicade');

	function connection(){
		try{
			$PDO = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB_NAME,MYSQL_USER,MYSQL_PASSWORD);
		}catch(pdoexception $e){
			echo 'Falha ao conectar com o banco de dados: '.$e->getMessage();
			die;
		}
		return $PDO;
	}
 ?>