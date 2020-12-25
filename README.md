## HTTP header collection for PHP 7.1+ (incl. PHP 8) based on PSR-7

[![Gitter](https://badges.gitter.im/sunrise-php/support.png)](https://gitter.im/sunrise-php/support)
[![Build Status](https://scrutinizer-ci.com/g/sunrise-php/http-header-collection/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-collection/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sunrise-php/http-header-collection/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-collection/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sunrise-php/http-header-collection/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-collection/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/sunrise/http-header-collection/v/stable)](https://packagist.org/packages/sunrise/http-header-collection)
[![Total Downloads](https://poser.pugx.org/sunrise/http-header-collection/downloads)](https://packagist.org/packages/sunrise/http-header-collection)
[![License](https://poser.pugx.org/sunrise/http-header-collection/license)](https://packagist.org/packages/sunrise/http-header-collection)

## Installation

```bash
composer require sunrise/http-header-collection
```

## How to use?

```php
use Sunrise\Http\Header\HeaderCollection;

$headers = new HeaderCollection([
    new XFooHeader(),
    new XBarHeader(),
]);

$headers->add(new XBazHeader());
$headers->add(new XQuxHeader());

// Sets the collection to the PSR-7 message
$message = $headers->setToMessage($message);

// Adds the collection to the PSR-7 message
$message = $headers->addToMessage($message);

// Converts the collection to an array
$headers->toArray();
```

## What are HTTP headers?

https://github.com/sunrise-php/http-header-kit

## Test run

```bash
php vendor/bin/phpunit
```

## Useful links

https://www.php-fig.org/psr/psr-7/
