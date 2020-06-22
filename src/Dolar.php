<?php
	namespace DolarArg;

	class Dolar
	{
		public $tipo; // string (oficial, blue, ccl)
		public $compra; // float
		public $venta; // float
		public $variacion; // float
		public $fecha; // DateTime

		/**
		 * Calcular valor dólar solidario
		 * Oficial + Impuesto PAIS (30%)
		 * @return float
		 */
		public function solidario()
		{
			if ($this->tipo == "oficial")
			{
				return (($this->venta * 0.3) + $this->venta);
			}
			else {
				return $this->venta;
			}
		}
	}
?>