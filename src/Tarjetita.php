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
	private $id;
	private $plus;
	protected $descuento;
	protected $valorColectivo = 8.5;
	protected $valorBici = 12;
	
	public function __construct() {
		$this->descuento = 1;
		$this->id = rand(100000, 999999);

	}

	public function pagar(Transporte $transporte, $fecha_y_hora) {

		if ($transporte->tipo() == "Colectivo") {
			
			$trasbordo = false;

			if (count($this->viajes) > 0) {
				if (end($this->viajes)->tiempo() - strtotime($fecha_y_hora) < 3600) {
					$trasbordo = true;
				}
			}

			$monto = $this->valorColectivo * $this->descuento;


			if ($trasbordo)
				$monto = round($monto * 0.33, 2);

			if ($this->saldo-$monto < 0 && $this->plus > 0) {
				print ("Viaje PLUS #" . $this->plus . ".\n");
				$this->plus -= 1;

			}
			else if ($this->plus <= 0) {
				print ("Saldo insuficiente.\n");
				return;
			}
			else
				$this->saldo -= $monto;

			array_push($this->viajes, new Boleto($fecha_y_hora, $transporte->tipo(), $transporte->linea(), $this->saldo, $this->id);
		
		} else if ($transporte->tipo() == "Bici") {
			if ($this->saldo-$monto < 0) {
				print ("Saldo insuficiente.\n");
				return;
			}

			$this->saldo -= $this->valorBici;
			array_push($this->viajes, new Boleto($fecha_y_hora, $transporte->tipo(), $transporte->patente(), $this->saldo, $this->id));
		}

		print ("Costo del boleto: $" . $monto . "\n");
	}

	public function recargar($monto) {
		if ($monto == 290)
			$this->saldo += 340;
		else if ($monto = 544)
			$this->saldo += 680;
		else
			$this->saldo += $monto;

		$this->saldo -= $this->valorColectivo*(2-$this->plus);

		$this->plus = 2;
	}

	public function saldo() {
		return $this->saldo;
	}

	public function viajesRealizados() {
		return $this->viajes;
	}
}

?>