<?php
	// composer autoload
	require('../../../autoload.php');

	use DolarArg\DolarArg;

	// Valor del dolar billete del día
	var_dump(DolarArg::valorDolar("billetes"));

	// Valor del dolar billete en X día
	var_dump(DolarArg::valorDolar("billetes", "2020-01-01"));

	// Valores de ambos tipos
	var_dump(DolarArg::valorDolar());
?>