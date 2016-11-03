<?php

namespace Tarj;

class Boleto {

	private $fecha;
	private $tipo;
	private $linea;
	private $saldoRestante;
	private $idTarjeta;

	public function __construct ($fecha, $tipo, $linea, $saldoRestante, $idTarjeta) {
		$this->fecha = $fecha;
		$this->tipo = $tipo;
		$this->linea = $linea;
		$this->saldoRestante = $saldoRestante;
		$this->idTarjeta = $idTarjeta;

		print ("Boleto emitido.\n");
	}

	public function getFecha () {
		return $this->fecha;
	}

	public function getTipo () {
		return $this->tipo;
	}

	public function getLinea () {
		return $this->linea;
	}

	public function getSaldo () {
		return $this->saldoRestante;
	}

	public function getId () {
		return $this->idTarjeta;
	}

}

?>