<?php 
	class UserLogin{
		private $id_user, $user_name, $password, $nivel, $email, $numero_inscricao;

		public function getId(){
			return $this->id_user;
		}

		public function setId($id_user){
			$this->id_user = $id_user;
		}

		public function getName(){
			return $this->user_name;
		}

		public function setName($user_name){
			$this->user_name = $user_name;
		}

		public function getPassword(){
			return $this->password;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function getNivel(){
			return $this->nivel;
		}

		public function setNivel($nivel){
			$this->nivel = $nivel;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getNumeroInscricao(){
			return $this->numero_inscricao;
		}

		public function setNumeroInscricao($numero_inscricao){
			$this->numero_inscricao = $numero_inscricao;
		}
	}
 ?>