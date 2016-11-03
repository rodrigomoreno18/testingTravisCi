<?php

namespace Tarj;

class MedioBoleto extends Tarjetita {
	public function __construct() {
		$this->descuento = 0.5;
		$this->plus = 2;
		$this->id = rand(100000, 999999);
	}
}

?>