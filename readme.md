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

In Laravel 5.5, and above, the package will auto-register the service provider. In Laravel 5.4 you must install this service provider.

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

## Usage outside of Laravel
You can use this package without Laravel, but configuration files wont be used, so you must provide the keys to the class.

Call the `config()` method in the Economic class if no keys are provided. But if you remember to provide keys, it should never be called. 

Otherwise register a global method for `config` until there's a framework agnostic version (coming eventually) 

## [Contributors](https://github.com/LasseRafn/laravel-economic/graphs/contributors)
