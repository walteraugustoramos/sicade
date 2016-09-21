<?php 
	class Administrador{
		private $id, $name, $cpf, $email, $endereco, $numero, $bairro, $estado, $cidade, $celular, $users_id_user;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		public function getCpf(){
			return $this->cpf;
		}

		public function setCpf($cpf){
			$this->cpf = $cpf;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getEndereco(){
			return $this->endereco;
		}

		public function setEndereco($endereco){
			$this->endereco = $endereco;
		}

		public function getNumero(){
			return $this->numero;
		}

		public function setNumero($numero){
			$this->numero = $numero;
		}

		public function getBairro(){
			return $this->bairro;
		}

		public function setBairro($bairro){
			$this->bairro = $bairro;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
		}

		public function getCidade(){
			return $this->cidade;
		}

		public function setCidade($cidade){
			$this->cidade = $cidade;
		}

		public function getCelular(){
			return $this->celular;
		}

		public function setCelular($celular){
			$this->celular = $celular;
		}

		public function getUserIdUser(){
			return $this->$users_id_user;
		}

		public function setUserIdUser($users_id_user){
			$this->$users_id_user = $users_id_user;
		}
	}
 ?>