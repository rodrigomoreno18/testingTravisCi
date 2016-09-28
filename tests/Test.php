<?php
namespace Tarj;

use PHPUnit\Framework\TestCase;

class TarjetitaTest extends TestCase {
	public $tarjeta;
	public $colectivo;
	public $viaje;
	public $tarjetaAlternativa;

	public function setUp() {
		$this->viaje = new Viaje("Colectivo", 8.5, "146 Rojo", "20/08/16 20:00");
		$this->colectivo = new Colectivo("146 Rojo", "Rosario Bus");
		$this->tarjeta = new Tarjetita();
	}

	public function testColectivo() {
		$cole = $this->colectivo->linea();
		$this->assertEquals("146 Rojo", $cole);
	}

	public function testViaje() {
		$tipo = $this->viaje->tipo();
		$this->assertEquals($tipo, "Colectivo");

		$monto = $this->viaje->monto();
		$this->assertEquals($monto, 8.5);

		$transp = $this->viaje->transporte();
		$this->assertEquals($transp, "146 Rojo");

		$tiempo = $this->viaje->tiempo();
		$this->assertEquals($tiempo, "20/08/16 20:00");
	}

	public function testTarjetita() {
		$saldoInicial = $this->tarjeta->saldo();
		$this->tarjeta->recargar(290);
		$this->assertEquals(340, $this->tarjeta->saldo() - $saldoInicial);

		$saldoInicial = $this->tarjeta->saldo();
		$this->tarjeta->pagar($this->colectivo, "21/09/16 16:00");
		$this->assertEquals($saldoInicial-8.5, $this->tarjeta->saldo());

		$this->tarjetaAlternativa = new PaseLibre();
		$this->tarjetaAlternativa->recargar(50);
		$saldoInicial = $this->tarjetaAlternativa->saldo();
		$this->tarjetaAlternativa->pagar($this->colectivo, "12/03/16 18:32");
		$this->assertEquals($saldoInicial, $this->tarjetaAlternativa->saldo());

		$this->tarjetaAlternativa = new MedioBoleto();
		$this->tarjetaAlternativa->recargar(50);
		$saldoInicial = $this->tarjetaAlternativa->saldo();
		$this->tarjetaAlternativa->pagar($this->colectivo, "12/03/16 18:32");
		$this->assertEquals($saldoInicial-4.25, $this->tarjetaAlternativa->saldo());
	}

}

?>