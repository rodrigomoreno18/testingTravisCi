<?php

$tarjeta = new Tarjetita();

$tarjeta->recargar(272);
echo $tarjeta->saldo() . "<br>";

$colectivo1 = new Colectivo("146 Rojo", "Rosario Bus");
$tarjeta->pagar($colectivo1, "20/08/16 20:50");
echo $tarjeta->saldo() . "<br>";

$colectivo135 = new Colectivo("135", "Rosario Bus");
$tarjeta->pagar($colectivo135, "2016/06/30 23:10");
echo $tarjeta->saldo() . "<br>";
$tarjeta->pagar($bici, "2016/07/02 08:10");