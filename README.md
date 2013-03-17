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


## Basic Usage

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


## Options

You can set different options with instantiation or the setter for the appropriate option.

```php
$chain = new \Validator\Chain('value', ['option' => 'value']);
```


### throwExceptionOnFailure

If this option is set to `true` then `Chain` will throw a `Validator\Exception` if a validation failed.

Default is set to `false`

```php
$chain = new \Validator\Chain('value', ['throwExceptionOnFailure' => true]);

try {
    $chain
        ->isString()         // everything fine
        ->minimumLengthOf(2) // everything fine
        ->isArray()          // \Validator\Exception will be thrown
        ->isArray();         // will not perform
} catch (\Validator\Excetion $e) {
    echo 'validation failed!';
}
```

The setter for this option is `throwExceptionOnFailure()`

```php
$chain->throwExceptionOnFailure(true);
$chain->throwExceptionOnFailure(false);
$chain->throwExceptionOnFailure(); // set this option to true
```


### stopValidationOnFailure

If this option is set to `true` then `Chain` will not perform any further validation.

Default is set to `true`

```php
$chain = new \Validator\Chain('value', ['stopValidationOnFailure' => true]);

$chain
    ->isString()    // everthing fine
    ->isArray()     // validation fail
    ->isInteger();  // will not perform
```

The setter for this option is `stopValidationOnFailure()`

```php
$chain->stopValidationOnFailure(true);
$chain->stopValidationOnFailure(false);
$chain->stopValidationOnFailure(); // set this option to true
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
```


## License

This package is licensed under the MIT License. See the LICENSE file for details.