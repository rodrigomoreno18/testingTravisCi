<?php

namespace Tarj;

class Bici extends Transporte {
	private $patente;

	public function __construct($patente) {
		$this->tipo = "Bici";
		$this->patente = $patente;
	}

	public function getPatente() {
		return $this->patente;
	}
}

?>