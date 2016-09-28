<?php

namespace Tarj;

class Colectivo extends Transporte {
	private $empresa;
	private $linea;

	public function __construct($linea, $empresa) {
		$this->tipo = "Colectivo";
		$this->linea = $linea;
		$this->empresa = $empresa;
	}

	public function linea() {
		return $this->linea;
	}
}

?>