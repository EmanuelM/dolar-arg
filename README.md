# DolarArg

Cotización actual del dólar en Argentina, valor según página del Banco de la Nación Argentina.

Obtenido mediante _"web scraping"_.

## Instalación

Clonar/bajar repositorio y ejecutar instalación de dependencias, se debe tener [Composer](https://getcomposer.org/).

```bash
~\dolar-arg> composer install
```

## Uso

```php
$dolarArg = new DolarArg;

/* Valor del dólar hoy en ambas cotizaciones */
$dolarHoy = $dolarArg->valorDolar(); // Array of objects Dolar

/* Valor del dólar hoy en divisas */
$dolarHoy = $dolarArg->valorDolar("divisas"); // Object Dolar

/* Valor del dólar hoy en billetes  */
$dolarHoy = $dolarArg->valorDolar("billetes"); // Object Dolar

/* Valor del dólar según fecha de cotización en billetes */
$dolarHoy = $dolarArg->valorDolar("ambas", "2019-10-19"); // Array of objects Dolar
$dolarHoy = $dolarArg->valorDolar("billetes", "2019-10-19"); // Object Dolar
```

## Contribuciones

Se aceptan todo tipo de PRs, cualquier cosa podes abrir un Issue.

## Licencia
[MIT](https://choosealicense.com/licenses/mit/)