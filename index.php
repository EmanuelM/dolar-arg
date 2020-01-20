<?php
	/** Composer autoload */
	require(__DIR__.'/vendor/autoload.php');

	$dolarArg = new DolarArg;

	/**
	 * Valor del dólar hoy en ambas cotizaciones
	 * @var array
	 */
	// $dolarHoy = $dolarArg->valorDolar();

	/**
	 * Valor del dólar hoy en divisas
	 * @var object Dolar
	 */
	$dolarHoy = $dolarArg->valorDolar("divisas");

	/**
	 * Valor del dólar hoy en billetes
	 * @var object Dolar
	 */
	// $dolarHoy = $dolarArg->valorDolar("billetes");

	/**
	 * Valor del dólar según fecha de cotización en billetes
	 * @var object Dolar
	 */
	// $dolarHoy = $dolarArg->valorDolar("billetes", "2019-10-19");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Dólar Argentina</title>
</head>
<body>
	<h2>Valor actual del dólar en Argentina</h2> <p>(según el Banco de la Nación Argentina)</p>
	<?php if ($dolarHoy instanceof Dolar) { ?>
	<ul>
		<li><b>Cotización:</b> <?= $dolarHoy->cotizacion ?></li>
		<li><b>Ultimo cierre:</b> <?= $dolarHoy->fecha->format('d/m/Y') ?></li>
		<li>------------------------------------------------</li>
		<li><b>Compra:</b> $<?= $dolarHoy->compra ?></li>
		<li><b>Venta:</b> $<?= $dolarHoy->venta ?></li>
	</ul>
	<?php } else { ?>
		<p><?= $dolarHoy['errors'] ?></p>
	<?php } ?>
</body>
</html>