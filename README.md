# DolarArg

Cotización del dólar según página del Banco de la Nación Argentina.

## Instalación

Desde [Composer](https://getcomposer.org/)

```bash
composer require "emanuelmart/dolar-arg:*"
```

## Uso

```php
require(__DIR__.'/vendor/autoload.php'); # composer autoload

use DolarArg\DolarArg

# Valor del dólar en ambos formatos
$usd = DolarArg::valorDolar();

# Valor del dólar divisa
$usd = DolarArg::valorDolar('divisas');

# Valor del dólar billete
$usd = DolarArg::valorDolar('billetes');

# Valor del dólar billete en X fecha, de formato YYYY-MM-DD
$usd = DolarArg::valorDolar('billetes', '2020-01-01');
```

## Contribuciones

Se aceptan todo tipo de PRs, cualquier cosa podes abrir un Issue.

## Licencia

[MIT](https://choosealicense.com/licenses/mit/)