<?php 
	class Visitante{
		private $id, $name, $cpf, $email, $celular, $users_id_user;

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