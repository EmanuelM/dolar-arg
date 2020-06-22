<?php
	namespace DolarArg;

	use DateTime;
	use DateTimeZone;
	use GuzzleHttp\Client;
	use DolarArg\Dolar;

	class DolarArg
	{
		// valor obtenido de API LaNación/InvertirOnline
		private static $www = "https://api-contenidos.lanacion.com.ar/json/V3";
		// DateTimeZone -> Buenos Aires, Argentina
		private static $timezone = "America/Argentina/Buenos_Aires";

		/**
		 * Obtener valor dólar oficial según BNA
		 * @return Dolar
		 */
		public function oficial()
		{
			$client = new Client();
			$request = $client->get(DolarArg::$www."/economia/cotizacion/DBNA");

			if ($request->getStatusCode() == 200)
			{
				$data = json_decode($request->getBody());

				$dolar = new Dolar;
				$dolar->tipo = "oficial";
				$dolar->venta = (float) str_replace(",", ".", $data->venta);
				$dolar->compra = (float) str_replace(",", ".", $data->compra);
				$dolar->variacion = (float) str_replace(",", ".", $data->variacion);
				$dolar->fecha = new DateTime($data->fecha, new DatetimeZone(DolarArg::$timezone));

				return $dolar;
			}
			else
			{
				return null;
			}
		}

		/**
		 * Obtener valor dólar Contado con Liquidación
		 * @return Dolar
		 */
		public function ccl()
		{
			$client = new Client();
			$request = $client->get(DolarArg::$www."/economia/cotizacionblue/DCCL");

			if ($request->getStatusCode() == 200)
			{
				$data = json_decode($request->getBody());

				$dolar = new Dolar;
				$dolar->tipo = "ccl";
				$dolar->venta = (float) str_replace(",", ".", $data->venta);
				$dolar->compra = (float) str_replace(",", ".", $data->compra);
				$dolar->variacion = (float) str_replace(",", ".", $data->variacion);
				$dolar->fecha = new DateTime($data->fecha, new DatetimeZone(DolarArg::$timezone));

				return $dolar;
			}
			else
			{
				return null;
			}
		}

		public function blue()
		{
			$client = new Client();
			$request = $client->get(DolarArg::$www."/economia/cotizacionblue/DBLUE");

			if ($request->getStatusCode() == 200)
			{
				$data = json_decode($request->getBody());

				$dolar = new Dolar;
				$dolar->tipo = "blue";
				$dolar->venta = (float) str_replace(",", ".", $data->venta);
				$dolar->compra = (float) str_replace(",", ".", $data->compra);
				$dolar->variacion = (float) str_replace(",", ".", $data->variacion);
				$dolar->fecha = new DateTime($data->fecha, new DatetimeZone(DolarArg::$timezone));

				return $dolar;
			}
			else
			{
				return null;
			}
		}
	}
?>