<?php
	use Goutte\Client;

	class DolarArg {
		private $client;
		// valor obtenido del Banco de la Nación Argentina
		private $www = "https://www.bna.com.ar";

		/** Seteo de cliente Guzzle */
		public function __construct() {
			$this->client = new Client();
		}

		/**
		 * Obtener valor del dólar divisas al ultimo cierre
		 * @return object Dolar
		 */
		private function dolarDivisas() {
			$crawler = $this->client->request("GET", "{$this->www}/Cotizador/MonedasHistorico");
    		// damos inicio al Dolar
    		$dolar = new Dolar;
    		$dolar->cotizacion = "divisas";
			// filtramos todas las filas por las dudas que cambie la ubicación del dolar en la tabla
			$rows = $crawler->filter('td');
    		if (count($rows)) {
				foreach($rows as $key => $node) {
					if ($node->textContent == "Dolar U.S.A") {
						$dolar->compra = (float) $rows->eq($key+1)->text();
						$dolar->venta = (float) $rows->eq($key+2)->text();
						break;
					}
				}
				// obtenemos ultimo cierre de operaciones
	    		$fecha = $crawler->filter('div.titulo-cotizador');
	    		$fecha = explode(" ", $fecha->eq(0)->text());
	    		$fecha = DateTime::createFromFormat('d/m/Y', $fecha[1], new DateTimeZone('America/Argentina/Buenos_Aires'));
	    		$dolar->fecha = $fecha;
	    		// devolvemos el objeto
				return $dolar;
			}
			// día feriado/sabado/domingo/error
			else {
				return ["errors" => "No hay cotizaciones pendientes para esta fecha. Puede ser que sea sábado, domingo, feriado o lunes temprano."];
			}
		}

		/**
		 * Obtener valor del dólar billetes al ultimo cierre
		 * Posibilidad de poder filtrar por fecha
		 * @param  string $fecha_cotizacion - formato 'Y-m-d', por defecto hoy
		 * @return object Dolar
		 */
		private function dolarBilletes(string $fecha_cotizacion = "now") {
			// setear fecha de cotización
			$fecha_cotizacion = new DateTime($fecha_cotizacion);
			// seteamos filtros
			$query = [
				"id=billetes",
				"fecha={$fecha_cotizacion->format('d/m/Y')}",
				"filtroEuro=0",
				"filtroDolar=1",
			];
			$query = implode('&', $query);
			// request al BNA
			$crawler = $this->client->request("GET", "{$this->www}/Cotizador/HistoricoPrincipales?{$query}");
    		// damos inicio al Dolar
    		$dolar = new Dolar;
    		$dolar->cotizacion = "billetes";
			// filtramos todas las filas por las dudas que cambie la ubicación del dolar en la tabla
			$rows = $crawler->filter('td');
    		// var_dump($rows); exit;
    		if (count($rows) > 0) {
				foreach($rows as $key => $node) {
					if ($node->textContent == "Dolar U.S.A") {
						$dolar->compra = (float) str_replace(",", ".", $rows->eq($key+1)->text());
						$dolar->venta = (float) str_replace(",", ".", $rows->eq($key+2)->text());
			    		$dolar->fecha = DateTime::createFromFormat('d/m/Y', $rows->eq($key+3)->text(), new DateTimeZone('America/Argentina/Buenos_Aires'));

						// cortar si el cierre es la fecha de cotización pasada
						if ($rows->eq($key+3)->text() == $fecha_cotizacion->format('d/m/Y')) break;
					}
				}
	    		// devolvemos el objeto
				return $dolar;
			}
			// día feriado/sabado/domingo/error
			else {
				return ["errors" => "No hay cotizaciones pendientes para esta fecha. Puede ser que sea sábado, domingo, feriado o lunes temprano."];
			}
		}

		/**
		 * Valor del dólar
		 * @param  string $cotizacion       - ambas/divisas/billetes
		 * @param  string $fecha_cotizacion - valor al ult. cierre de fecha de cotización
		 * @return object/array
		 */
		public function valorDolar($cotizacion = "ambas", $fecha_cotizacion = "now") {
			switch ($cotizacion) {
				case "divisas":
					return $this->dolarDivisas();
					break;

				case "billetes":
					return $this->dolarBilletes($fecha_cotizacion);
					break;

				case "ambas":
					return [
						"divisas"  => $this->dolarDivisas(),
						"billetes" => $this->dolarBilletes($fecha_cotizacion),
					];
					break;

				default:
					return false;
					break;
			}
		}
	}
?>