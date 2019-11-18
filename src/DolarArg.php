<?php
	class DolarArg {
		private $client;
		// valor obtenido del Banco de la Nación Argentina
		private static $www = "https://www.bna.com.ar";

		/** Seteo de cliente Guzzle */
		public function __construct() {
			$this->client = new GuzzleHttp\Client(['base_uri' => self::$www]);
		}

		/**
		 * Obtener valor del dólar divisas al ultimo cierre
		 * @return object Dolar
		 */
		private function dolarDivisas() {
			$response = $this->client->request('GET', '/Cotizador/MonedasHistorico');
			$body = $response->getBody();
			$body = $body->getContents();
			// parsear body
    		$dom = new DOMDocument;
    		$dom->loadHTML($body);
    		// damos inicio al Dolar
    		$dolar = new Dolar;
    		$dolar->cotizacion = "divisas";
			// filtramos todas las filas por las dudas que cambie la ubicación del dolar en la tabla
    		$rows = $dom->getElementsByTagName('td');
    		if (count($rows)) {
				foreach($rows as $key => $node) {
					if ($node->nodeValue == "Dolar U.S.A") {
						$dolar->compra = (float) $rows[$key+1]->nodeValue;
						$dolar->venta = (float) $rows[$key+2]->nodeValue;
						break;
					}
				}
				// obtenemos ultimo cierre de operaciones
				$finder = new DomXPath($dom);
	    		$fecha = $finder->query("//*[contains(@class, 'titulo-cotizador')]");
	    		$fecha = explode(" ", $fecha[0]->nodeValue);
	    		$fecha = DateTime::createFromFormat('d/m/Y', $fecha[1], new DateTimeZone('America/Argentina/Buenos_Aires'));
	    		$dolar->fecha = $fecha;
	    		// devolvemos el objeto
				return $dolar;
			}
			// día feriado/sabado/domingo/error
			else {
				return ["error" => "No hay cotizaciones pendientes para esta fecha. Puede ser que sea sábado, domingo, feriado o lunes temprano."];
			}
		}

		/**
		 * Obtener valor del dólar billetes al ultimo cierre
		 * Posibilidad de poder filtrar por fecha
		 * @param  string $fecha_cotizacion - formato 'Y-m-d', por defecto hoy
		 * @return object Dolar
		 */
		private function dolarBilletes($fecha_cotizacion = "now") {
			// setear fecha de cotización
			$fecha_cotizacion = new DateTime($fecha_cotizacion);
			// request al BNA
			$response = $this->client->request('GET', '/Cotizador/HistoricoPrincipales', [
				"query" => [
					"id" => "billetes",
					"fecha" => $fecha_cotizacion->format('d/m/Y'),
					"filtroEuro" => 0,
					"filtroDolar" => 1,
				]
			]);
			$body = $response->getBody();
			$body = $body->getContents();
			// parsear body
    		$dom = new DOMDocument;
    		$dom->loadHTML($body);
    		// damos inicio al Dolar
    		$dolar = new Dolar;
    		$dolar->cotizacion = "billetes";
			// filtramos todas las filas por las dudas que cambie la ubicación del dolar en la tabla
    		$rows = $dom->getElementsByTagName('td');
    		if (count($rows) > 0) {
				foreach($rows as $key => $node) {
					if ($node->nodeValue == "Dolar U.S.A") {
						$dolar->compra = (float) str_replace(",", ".", $rows[$key+1]->nodeValue);
						$dolar->venta = (float) str_replace(",", ".", $rows[$key+2]->nodeValue);
			    		$dolar->fecha = DateTime::createFromFormat('d/m/Y', $rows[$key+3]->nodeValue, new DateTimeZone('America/Argentina/Buenos_Aires'));

						// cortar si el cierre es la fecha de cotización pasada
						if ($rows[$key+3]->nodeValue == $fecha_cotizacion->format('d/m/Y')) break;
					}
				}
	    		// devolvemos el objeto
				return $dolar;
			}
			// día feriado/sabado/domingo/error
			else {
				return ["error" => "No hay cotizaciones pendientes para esta fecha. Puede ser que sea sábado, domingo, feriado o lunes temprano."];
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