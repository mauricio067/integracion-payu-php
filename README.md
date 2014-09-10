PayU - Integración con PHP
=========

##Requisitos previos para integrar PayU.

  - PHP 5.2.1
  - Descargar el [SDK](http://docs.payulatam.com/wp-content/uploads/2014/02/payu-php-sdk.zip) de PayU para PHP


##Requisitos Previos para el ejemplo
- PHP 5.3
- Tener instalado [Bower](http://bower.io/) para administrar las dependencias del Frontend
- Tener instalado el [Composer](https://getcomposer.org/) para administrar las dependencias de PHP

 
##Instalación del Ejemplo
Primeramente deberíamos clonar el repositorio del ejemplo

```sh
git clone https://github.com/mauricio067/integracion-payu-php.git

```
###Instalar dependencias del Frontend
Para el frontend del ejemplo se necesitan algunas dependencias como Bootsrtrap y JQuery y las instalamos corriendo el siguiente comando dentro del raíz del proyecto.

```sh
bower install

```
###Instalar dependencias de PHP
Para el ejemplo se utilizo un mini-framework SILEX que nos permite tener mas ordenado las rutas que vamos a utilizar. Para ello instalamos las dependencias con el Composer.
```sh
composer install

```
Despues de tener todas las dependencias voy a empezar a explicarles como integrar el mini proyecto con PayU.

###Primeros Pasos
Dentro de las herramientas que te ofrece PayU para realizar la integración con la pasarela transaccional, cuentas con la integración por medio del [SDK](http://docs.payulatam.com/wp-content/uploads/2014/02/payu-php-sdk.zip).
Después de  descargar lo, descomprimimos en el raíz.
```
/payu-php-sdk

```
###Estructura de nuestro proyecto PHP
Definimos para el raíz se cargue nuestra plantilla
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__,
));

//Renderizamos nuestro template donde va a contar con los formularios de los metodos de pagos
// http://localhost/
$app->get('/', function() use($app) {
    return $app['twig']->render('template.html');
});
/*TODO: Definir ruta para procesar pagos con tarjeta de crédito*/
/*TODO: Definir ruta para procesar pagos en efectivo*/

$app->run();


```
Definimos una ruta la cual va a procesar nuestro pago con tarjeta de crédito, por ahora no hace nada.
```php
$app->post('/creditcard-payment', function() use($app) {
    return "";
});
```
Y definimos la ruta la cual se va a encargar de procesar el pago con en efectivo.
```php
$app->post('/cash-payment', function() use($app) {
    return "";
});
```
####Importamos el SDK de PayU
En nuestro archivo PHP agregamos la sentencia require_once para incluir la librería de payu
```php
require_once __DIR__ .'/payu-php-sdk/lib/PayU.php';
```
Antes de realizar cualquier operación con el SDK PHP de PayU, se deben asignar ciertos valores iniciales a la clase PayU, los cuales son comunes para todas las operaciones soportadas por el SDK y se configuran dependiendo del comercio. A continuación se presenta un ejemplo de la configuración de esta clase.

```php
PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //apiKey de prueba.
PayU::$apiLogin = "11959c415b33d0c"; //apiLogin de prueba.
PayU::$merchantId = "500238"; //Id de Comercio de prueba.
PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
PayU::$isTest = true; //Dejarlo True cuando sean pruebas.
```
Adicionalmente, se debe configurar el API para que dirija las peticiones a la URL correspondientes utilizando la clase Environment como se muestra a continuación:
```php
//URL de Pagos
Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
//URL de Consultas
Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
```
> Aclaración: Únicamente es necesario definir esto para entorno de pruebas.

###Implementación de pago de por medio de tarjeta de crédito
Para la ejecución de cada una de las operaciones provistas por el SDK PHP de PayU, se debe enviar un argumento de parámetros al método correspondiente, que contiene toda la información de la transacción a procesar. A continuación se presenta un ejemplo de la construcción de este arreglo:

```php
$parameters = array(
PayUParameters::REFERENCE_CODE => 'referenceCode',
PayUParameters::PAYER_NAME=> 'PayerName',
PayUParameters::COUNTRY => PayUCountries::CO,
PayUParameters::ACCOUNT_ID => "1",
PayUParameters::CURRENCY => "COP",
PayUParameters::DESCRIPTION => 'description',
PayUParameters::VALUE => '10000',
);
```
De la misma forma vamos a implementarlo en nuestro proyecto, estos parámetros son necesarios para tipo de pago en efectivo y tipo de pagos con tarjeta de crédito
```php
$parameters = array(
        //Ingrese aquí el número de cuotas.
		PayUParameters::INSTALLMENTS_NUMBER => "1",
        //Ingrese aquí el nombre del país.
		PayUParameters::COUNTRY => PayUCountries::MX,
        //Ingrese aquí el identificador de la cuenta.
		PayUParameters::ACCOUNT_ID => "500547",
        //Cookie de la sesión actual.
		PayUParameters::PAYER_COOKIE => "cookie_" . time(),
        //Ingrese aquí la moneda.
		PayUParameters::CURRENCY => "MXN",
		//Se ingresa el id de usuario, una referencia del sistema
		PayUParameters::PAYER_ID => "125",
        //Ingrese aquí el código de referencia.
		PayUParameters::REFERENCE_CODE => "100",
        //Ingrese aquí la descripción.
		PayUParameters::DESCRIPTION => "Test de pago",
        //Ingrese aquí el valor o monto a pagar.
		PayUParameters::VALUE => 300,
        //Ingrese aquí su firma. “{APIKEY}~{MERCHANTID}~{REFERENCE_CODE}~{VALUE}~{CURRENCY}”
		PayUParameters::SIGNATURE => md5(PayU::$apiKey . "~" . PayU::$merchantId . "~" ."100" . "~" . "300" . "~MXN"),

		);
$app->post('/creditcard-payment', function() use($app,$parameters) {
    return "";
});
$app->post('/cash-payment', function() use($app,$parameters) {
	return "";
});
```
Después deberíamos definir los parámetros necesarios para procesar el pago por tarjeta de crédito
```php
$app->post('/creditcard-payment', function() use($app,$parameters) {
	/*Recibimos por POST los datos de la tarjeta de credito*/
	$parameters[PayUParameters::PAYER_NAME] = $app['request']->get('payer_name');
	$parameters[PayUParameters::CREDIT_CARD_NUMBER] = $app['request']->get('credit_card_number');
	$parameters[PayUParameters::CREDIT_CARD_EXPIRATION_DATE] = $app['request']->get('year_exp')."/" . $app['request']->get('month_exp');
	$parameters[PayUParameters::CREDIT_CARD_SECURITY_CODE] = $app['request']->get('ccv');
	$parameters[PayUParameters::PROCESS_WITHOUT_CVV2] = false;
	$parameters[PayUParameters::PAYMENT_METHOD] = $app['request']->get('payment_method');
	return "";
});
```
Para realizar la autorización y captura del pago debemos realizarlo de la siguiente manera:
```php
$payu_response = PayUPayments::doAuthorizationAndCapture($parameters);
```
Para información sobre esto pueden acceder a la documentación de PayU:

[Documentación de Pagos Actualizada (Ej. solo JAVA pero valido para cuestiones genéricas de la api)
](http://desarrolladores.payulatam.com/sdk-pagos/)
[Documentación de Pagos Antigua (Ej. en JAVA/PHP)](http://docs.payulatam.com/integracion-con-api/integracion-sdk/pagos/)

En nuestro ejemplo quedaría de la siguiente manera
```php
$response = array("status"=>"ok");
	$statusCode = 200;
	try {
		$payu_response = PayUPayments::doAuthorizationAndCapture($parameters);
		if ($payu_response->code == "SUCCESS") {
			if ($payu_response->transactionResponse->state == "APPROVED") {
				//TODO: Realizar una acción en el caso de que el estado de la transacción este aprobado.
			}
		} else {
			//TODO
			$response["status"] = "error";
			$response["code"] = $payu_response->code;
			$statusCode = 500;
		}
	}catch (PayUException $exc) {
		$response["status"] = "error";
		$response["message"] = $exc->getMessage();
		$statusCode = 500;
	}
	return $app->json($response,$statusCode);
```
###Implementación de pago en efectivo
Para la implementación de pago en efectivo es bastante similar con la diferencia que no recibimos los datos de la tarjeta de crédito sino el medio de pago offline, el DNI y nombre  del usuario que realizaría el pago, quedaría de la siguiente manera:
```php
$app->post('/cash-payment', function() use($app,$parameters) {
	$parameters[PayUParameters::PAYER_NAME] = $app['request']->get('payer_name');
	$parameters[PayUParameters::PAYER_COOKIE] = "cookie_ed_" . time();
	$parameters[PayUParameters::PAYER_DNI] = $app['request']->get('payer_dni');
	$parameters[PayUParameters::PAYMENT_METHOD] = $app['request']->get('payment_method');
	$response = array("status"=>"ok");
	$statusCode = 200;
	try {
		$payu_response = PayUPayments::doAuthorizationAndCapture($parameters);
		if ($payu_response->code == "SUCCESS") {
			if ($payu_response->transactionResponse->state == "APPROVED") {
				//TODO: Realizar una accion en el caso de que el estado de la transaccion este aprobado.
			}
		} else {
			//TODO
			$response["status"] = "error";
			$response["code"] = $payu_response->code;
			$statusCode = 500;
		}
	}catch (PayUException $exc) {
		$response["status"] = "error";
		$response["message"] = $exc->getMessage();
		$statusCode = 500;
	}
	return $app->json($response,$statusCode);
});
```
