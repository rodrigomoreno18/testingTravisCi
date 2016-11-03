<?php

namespace Tarj;

class PaseLibre extends Tarjetita {
	public function __construct() {
		$this->descuento = 0;
		$this->plus = 2;
		$this->id = rand(100000, 999999);
	}
}

?>