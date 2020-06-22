<?php
	require_once('../../../autoload.php');

	use DolarArg\DolarArg;

	$oficial = DolarArg::oficial();
	$ccl     = DolarArg::ccl();
	$blue    = DolarArg::blue();

	var_dump($oficial, $ccl, $blue);
?>