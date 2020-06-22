# DolarArg

Cotización del dólar según página [LaNación](https://www.lanacion.com.ar/dolar-hoy)/[InvertirOnline](https://www.invertironline.com/)

## Instalación

Mediante [Composer](https://getcomposer.org/)

```bash
composer require "emanuelmart/dolar-arg:*"
```

## Uso

```php
require(__DIR__.'/vendor/autoload.php'); # composer autoload

use DolarArg\DolarArg

# Valor del dólar oficial según BNA
$oficial = DolarArg::oficial();
$oficial->solidario(); # sumar impuesto PAIS +30%

# Valor del dólar contado con liquidación
$ccl = DolarArg::ccl();

# Valor del dólar blue
$blue = DolarArg::blue();

```

## Contribuciones

Se aceptan todo tipo de PRs, cualquier cosa podes abrir un Issue.

## Licencia

[MIT](https://choosealicense.com/licenses/mit/)