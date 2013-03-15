# ValidatorChain
[![Build Status](https://drone.io/github.com/pklink/ValidatorChain/status.png)](https://drone.io/github.com/pklink/ValidatorChain/latest)
[![Build Status](https://travis-ci.org/pklink/ValidatorChain.png?branch=master)](https://travis-ci.org/pklink/ValidatorChain)

A library to perform several validations in a chain.


## Installation

Install `ValidationChain` with Composer

Create or update your composer.json

```json
{
    "require": {
        "pklink/validation-chain": "0.*"
    }
}
```

And run Composer

```sh
php composer.phar install
```

Finally include Composers autoloader

```php
include __DIR__ . '/vendor/autoload.php';
```


## Usage

Create an instance of `Chain` with the value you like to check

```php
$chain = \Validation\Chain('check me');
```

Now, run some tests in a chain

```php
$chain
    ->isString()  // return instance of Chain
    ->isInteger() // return instance of Chain
    ->isArray()   // return instance of Chain
;
```

If you want to know if all validations run fine use the `isValid`-method

```php
$chain->isValid(); // return false
```

Alternatively you can use this in one statement:

```php
(new \Validation\Chain('check me'))
    ->isString()
    ->isInteger()
    ->isArray()
    ->isValid()
```


## Run Tests

You can use PHPUnit from the vendor-folder.

```sh
php composer.phar install --dev
php vendor/bin/phpunit tests/
```

or with code-coverage-report

```sh
php composer.phar install --dev
php vendor/bin/phpunit --coverage-html output tests/
``


## License

This package is licensed under the MIT License. See the LICENSE file for details.