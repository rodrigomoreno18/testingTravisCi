<?php
namespace Tarj;

interface Tarjeta {
	public function pagar(Transporte $transporte, $fecha_y_hora);
	public function recargar($monto);
	public function getSaldo();
	public function getViajesRealizados();
}


class Tarjetita implements Tarjeta {
	protected $viajes = [];
	protected $saldo = 0;
	protected $id;
	protected $plus;
	protected $descuento;
	protected $valorColectivo = 8.5;
	protected $valorBici = 12;
	
	public function __construct() {
		$this->descuento = 1;
		$this->plus = 2;
		$this->id = rand(100000, 999999);
	}

	public function pagar(Transporte $transporte, $fecha_y_hora) {

		$monto = 0;

		if ($transporte->getTipo() == "Colectivo") {
			
			$trasbordo = false;

			if (count($this->viajes) > 0) {
				if (strtotime($fecha_y_hora) - strtotime(end($this->viajes)->getFecha()) < 3600 && end($this->viajes)->getTipo() == "Colectivo") {
					$trasbordo = true;
				}
			}

			$monto = $this->valorColectivo * $this->descuento;


			if ($trasbordo)
				$monto = round($monto * 0.33, 2);

			if ($this->saldo-$monto < 0 && $this->plus > 0) {
				print ("Usando viaje PLUS #" . $this->plus . ".\n");
				$this->plus -= 1;
			}
			else if ($this->plus <= 0) {
				print ("Saldo insuficiente.\n");
				return;
			}
			else
				$this->saldo -= $monto;

			array_push($this->viajes, new Boleto($fecha_y_hora, $transporte->getTipo(), $transporte->getLinea(), $this->saldo, $this->id));
		
		} else if ($transporte->getTipo() == "Bici") {
			$monto = $this->valorBici;

			if ($this->saldo-$monto < 0) {
				print ("Saldo insuficiente.\n");
				return;
			}

			$this->saldo -= $this->valorBici;
			array_push($this->viajes, new Boleto($fecha_y_hora, $transporte->getTipo(), $transporte->getPatente(), $this->saldo, $this->id));
		}

		print ("Costo del boleto: $" . $monto . "\n");
	}

	public function recargar($monto) {
		if ($monto == 290) {
			$this->saldo += 340;
			print ("Recargados $340\n");
		}
		else if ($monto == 544) {
			$this->saldo += 680;
			print ("Recargados $680\n");
		}
		else {
			$this->saldo += $monto;
			print ("Recargados $" . $monto . "\n");
		}

		$this->saldo -= $this->valorColectivo*(2-$this->plus);

		print ("Descontados $" . $this->valorColectivo*(2-$this->plus) . " de viajes PLUS.\n");

		$this->plus = 2;

		print ("Saldo actual: $" . $this->saldo . "\n");
	}

	public function getSaldo() {
		return $this->saldo;
	}

	public function getPlus() {
		return $this->plus;
	}

	public function getViajesRealizados() {
		return $this->viajes;
	}
}

?>