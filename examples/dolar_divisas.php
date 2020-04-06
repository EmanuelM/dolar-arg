<?php
	// composer autoload
	require('../../../autoload.php');

	use DolarArg\DolarArg;

	// Valor del dolar divisa
	var_dump(DolarArg::valorDolar("divisas"));

	// Valores de ambos tipos
	var_dump(DolarArg::valorDolar());
?>