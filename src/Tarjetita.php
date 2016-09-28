<?php
namespace Tarj;

interface Tarjeta {
	public function pagar(Transporte $transporte, $fecha_y_hora);
	public function recargar($monto);
	public function saldo();
	public function viajesRealizados();
}


class Tarjetita implements Tarjeta {
	private $viajes = [];
	private $saldo = 0;
	protected $descuento;
	
	public function __construct() {
		$this->descuento = 1;
	}

	public function pagar(Transporte $transporte, $fecha_y_hora) {
		if ($transporte->tipo() == "Colectivo") {
			$trasbordo = false;
			if (count($this->viajes) > 0) {
				if (end($this->viajes)->tiempo() - strtotime($fecha_y_hora) < 3600) {
					$trasbordo = true;
				}
			}

			$monto = 0;
			if ($trasbordo)
				$monto = 2.81*$this->descuento;
			else
				$monto = 8.5*$this->descuento;

			array_push($this->viajes, new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora)));
			$this->saldo -= $monto;
		} else if ($transporte->tipo() == "Bici") {
			array_push($this->viajes, new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora)));
			$this->saldo -= 12;
		}
	}

	public function recargar($monto) {
		if ($monto == 290)
			$this->saldo += 340;
		else if ($monto = 544)
			$this->saldo += 680;
		else
			$this->saldo += $monto;
	}

	public function saldo() { return $this->saldo; }

	public function viajesRealizados() { return $this->viajes; }
}

?>