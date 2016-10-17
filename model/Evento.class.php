<?php 
	class Evento{
		private $id_evento, $nome, $descricao, $data_inicio, $hora_inicio, $data_fim, $hora_fim, $status, $carga_horaria, $quantidade_vagas;

		public function getIdEvento(){
			return $this->id_evento;
		}

		public function setIdEvento($id_evento){
			$this->id_evento = $id_evento;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
		}

		public function getDataInicio(){
			return $this->data_inicio;
		}

		public function setDataInicio($data_inicio){
			$this->data_inicio = $data_inicio;
		}

		public function getHoraInicio(){
			return $this->hora_inicio;
		}

		public function setHoraInicio($hora_inicio){
			$this->hora_inicio = $hora_inicio;
		}

		public function getDataFim(){
			return $this->data_fim;
		}

		public function setDataFim($data_fim){
			$this->data_fim = $data_fim;
		}

		public function getHoraFim(){
			return $this->hora_fim;
		}

		public function setHoraFim($hora_fim){
			$this->hora_fim = $hora_fim;
		}

		public function getStatus(){
			return $this->status;
		}

		public function setStatus($status){
			$this->status = $status;
		}

		public function getCargaHoraria(){
			return $this->carga_horaria;
		}

		public function setCargaHoraria($carga_horaria){
			$this->carga_horaria = $carga_horaria;
		}

		public function getQuantidadeVagas(){
			return $this->quantidade_vagas;
		}

		public function setQuantidadeVagas($quantidade_vagas){
			$this->quantidade_vagas = $quantidade_vagas;
		}
	}
 ?>