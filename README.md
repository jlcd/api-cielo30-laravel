# Provider Laravel para API Cielo 3.0 (Client [jlcd/api-cielo3.0](https://github.com/jlcd/api-cielo3.0))

## Descrição

Este provider utiliza o client [jlcd/api-cielo3.0](https://github.com/jlcd/api-cielo3.0), que por sua vez utiliza o [sdk oficial](https://github.com/DeveloperCielo/API-3.0-PHP) da Cielo.

Qualquer issue referente à comunicação com a Cielo deverá ser tratado diretamente nos [issues](https://github.com/jlcd/api-cielo3.0/issues) do client.

Versões do Laravel anteriores à `5.0` não foram testadas e o funcionamento não é garantido.

## Instalação

Via Composer: `composer require jlcd/api-cielo3.0-laravel`

Incluir o código abaixo na posição `providers` no arquivo `boostrap/app.php`
```php
(...)

   'providers' => [

    (...)

        /*
         * Package Service Providers...
         */

        // Cielo
        jlcd\CieloLaravel\CieloServiceProvider::class,

    (...)

    ],

(...)
```

Executar `php artisan vendor:publish` no projeto.

## Configuração

As variáveis de ambiente `CIELO_ID`, `CIELO_KEY` e `CIELO_ENV` deverão ser configuradas no arquivo `.env`.

Os valores aceitos para `CIELO_ENV` são:

- `sandbox`
- `production`

Ex.:

```plain
CIELO_ID=123435678
CIELO_KEY=25fbb99341c739dd84a7b06ec78c2cac718838630f30b182d033ce2e621c34f3
CIELO_ENV=sandbox
```

Como alternativa, após `vendor:publish`, as configurações poderão ser incluídas diretamente no arquivo de configuração `config/cielo.php`.

## Utilização

Exemplo utilizando o arquivo `routes/web.php`:

```php
<?php

use jlcd\Cielo\Resources\CieloPayment;
use jlcd\Cielo\Resources\CieloCreditCard;
use jlcd\Cielo\Resources\CieloCustomer;
use jlcd\Cielo\Resources\CieloOrder;

Route::get('/', function () {
    $payment = new CieloPayment();
    $payment->setValue(1541);

    $creditCard = new CieloCreditCard();
    $creditCard->setCardNumber('1234432112344321');
    $creditCard->setExpirationDate('12/2018');
    $creditCard->setBrand('visa');
    $creditCard->setSecurityCode('888');
    $creditCard->setHolder('Fulano');
    $payment->setCreditCard($creditCard);

    $order = new CieloOrder();
    $order->setId('123');

    $customer = new CieloCustomer();
    $customer->setName('Fulano');

    $payment = app()->cielo->payment($payment, $order, $customer);
    dd($payment);
});

Route::get('/cancel/{id}', function ($id) {
    $payment = new CieloPayment();
    $payment->setId($id);
    $payment->setValue(1541);

    $payment = app()->cielo->cancelPayment($payment);
    dd($payment);
});

Route::get('/capture/{id}', function ($id) {
    $payment = new CieloPayment();
    $payment->setId($id);
    $payment->setValue(1541);

    $payment = app()->cielo->capturePayment($payment);
    dd($payment);
});

Route::get('/tokenize', function () {
    $creditCard = new CieloCreditCard();
    $creditCard->setCardNumber("1234432112344321");
    $creditCard->setHolder("Comprador T Cielo");
    $creditCard->setExpirationDate("12/2018");
    $creditCard->setBrand("Visa");

    $customer = new CieloCustomer();
    $customer->setName('Fulano');

    $token = app()->cielo->tokenizeCreditCard($creditCard, $customer);
    dd($token);
});

Route::get('/paymenttoken/{id}', function ($id) {
    $payment = new CieloPayment();
    $payment->setValue(1541);

    $creditCard = new CieloCreditCard();
    $creditCard->setBrand('visa');
    $creditCard->setToken($id);
    $creditCard->setSecurityCode('888');
    $payment->setCreditCard($creditCard);

    $order = new CieloOrder();
    $order->setId('123');

    $customer = new CieloCustomer();
    $customer->setName('Fulano');

    $payment = app()->cielo->payment($payment, $order, $customer);
    dd($payment);
});

```

---

Para maiores detalhes vide repositório do client utilizado ([jlcd/api-cielo3.0](https://github.com/jlcd/api-cielo3.0)) e a [documentação oficial](https://developercielo.github.io/Webservice-3.0/).