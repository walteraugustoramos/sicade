<?php 
	class UserLogin{
		private $id_user, $user_name, $password, $nivel;

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
	}
 ?>