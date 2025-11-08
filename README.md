# Spreadsheet Translator - Google Drive Provider

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelvi/spreadsheet-translator-provider-googledrive.svg?style=flat-square)](https://packagist.org/packages/samuelvi/spreadsheet-translator-provider-googledrive)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelvi/spreadsheet-translator-provider-googledrive.svg?style=flat-square)](https://packagist.org/packages/samuelvi/spreadsheet-translator-provider-googledrive)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/samuelvicent/spreadsheet-translator-provider-googledrive/master.svg?style=flat-square)](https://travis-ci.org/samuelvicent/spreadsheet-translator-provider-googledrive)

Spreadsheet Translator - Google Drive Provider with no authentication.

## Installation

You can install the package via composer:

```bash
composer require samuelvi/spreadsheet-translator-provider-googledrive
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Atico\SpreadsheetTranslator\SpreadsheetTranslator;

$spreadsheetTranslator = new SpreadsheetTranslator([
    'provider' => 'google_drive',
    'source_resource' => 'https://docs.google.com/spreadsheets/d/1q7-h_uE-Ay-iQVR2n2_d_2G_2G_2G_2G_2G_2G_2G_2G_2G/edit#gid=0',
]);

$translations = $spreadsheetTranslator->getTranslations('en');
```

## Development

### Running tests

```bash
make test
```

### Running Rector

```bash
make rector
```
