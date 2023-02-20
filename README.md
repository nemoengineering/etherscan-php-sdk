# This is my package etherscan-php-sdk

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nemo/etherscan-php-sdk.svg?style=flat-square)](https://packagist.org/packages/nemo/etherscan-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/nemo/etherscan-php-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nemo/etherscan-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/nemo/etherscan-php-sdk.svg?style=flat-square)](https://packagist.org/packages/nemo/etherscan-php-sdk)

An object-oriented and typed PHP client for Etherscan API.

## Installation

You can install the package via composer:

```bash
composer require nemo/etherscan-php-sdk
```

## Usage

```php
$skeleton = new Nemo\Etherscan();
echo $skeleton->echoPhrase('Hello, Nemo!');
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
