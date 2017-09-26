# Laravel e-conomic REST wrapper

<p align="center"> 
<a href="https://packagist.org/packages/LasseRafn/laravel-economic"><img src="https://img.shields.io/packagist/dt/LasseRafn/laravel-economic.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/LasseRafn/laravel-economic"><img src="https://img.shields.io/packagist/v/LasseRafn/laravel-economic.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/LasseRafn/laravel-economic"><img src="https://img.shields.io/packagist/l/LasseRafn/laravel-economic.svg?style=flat-square" alt="License"></a>
</p>

## Installation

1. Require using composer

``` bash
composer require lasserafn/laravel-economic
```

In Laravel 5.5 the package will autoregister the service provider. In Laravel 5.4 you must install this service provider.

2. Add the EconomicServiceProvider to your `config/app.php` providers array.

``` php
<?php 
'providers' => [
    // ...
    \LasseRafn\Economic\EconomicServiceProvider::class,
    // ...
]
```

3. Copy the package config to your local config with the publish command: 

``` bash
php artisan vendor:publish --provider="LasseRafn\Economic\EconomicServiceProvider"
```

## [Contributors](https://github.com/LasseRafn/laravel-economic/graphs/contributors)
