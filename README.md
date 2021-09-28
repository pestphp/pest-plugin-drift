# PestConverter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mandisma/pest-converter.svg?style=flat-square)](https://packagist.org/packages/mandisma/pest-converter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mandisma/pest-converter/PHP%20Composer?label=tests)](https://github.com/mandisma/pest-converter/actions?query=workflow%3A"PHP+Composer"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/mandisma/pest-converter.svg?style=flat-square)](https://packagist.org/packages/mandisma/pest-converter)


PestConverter is a PHP library for convert PHPUnit Test to Pest Test.

## Before use

**Before using this converter, make sure your files are backed up.**

Install Pest before : <https://pestphp.com/docs/installation>

## Installation

You can install the package via composer:

```bash
composer require mandisma/pest-converter --dev
```

## Usage

```bash
# Convert tests
vendor/bin/pest-converter tests
```

## Testing

```bash
composer test
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Authors

- [mandisma](https://github.com/mandisma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
