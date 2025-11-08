# Spreadsheet Translator - Google Drive Provider

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelvi/spreadsheet-translator-provider-googledrive.svg?style=flat-square)](https://packagist.org/packages/samuelvi/spreadsheet-translator-provider-googledrive)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelvi/spreadsheet-translator-provider-googledrive.svg?style=flat-square)](https://packagist.org/packages/samuelvi/spreadsheet-translator-provider-googledrive)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A Google Drive provider for Spreadsheet Translator that requires no authentication. This provider allows you to fetch translations directly from publicly accessible Google Spreadsheets.

## Requirements

- PHP 8.4 or higher
- Composer

## Installation

You can install the package via composer:

```bash
composer require samuelvi/spreadsheet-translator-provider-googledrive
```

## Usage

### Basic Example

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Atico\SpreadsheetTranslator\SpreadsheetTranslator;

$spreadsheetTranslator = new SpreadsheetTranslator([
    'provider' => 'google_drive',
    'source_resource' => 'https://docs.google.com/spreadsheets/d/YOUR_SPREADSHEET_ID/edit#gid=YOUR_SHEET_ID',
]);

$translations = $spreadsheetTranslator->getTranslations('en');
```

### Configuration Options

- `provider`: Must be set to `'google_drive'`
- `source_resource`: The URL of your Google Spreadsheet (must be publicly accessible)
- `format`: Optional, defaults to `'csv'`
- `temp_local_source_file`: Optional, temporary file path for downloaded spreadsheet

### Making Your Spreadsheet Public

For this provider to work, your Google Spreadsheet must be publicly accessible:

1. Open your Google Spreadsheet
2. Click on "Share" button
3. Change to "Anyone with the link can view"
4. Copy the spreadsheet URL

## Development

### Installation

```bash
make install
```

### Running Tests

Run all tests:

```bash
make test
```

Run tests with coverage:

```bash
make test-coverage
```

### Code Quality

Run Rector (dry-run to see changes):

```bash
make rector-dry
```

Apply Rector changes:

```bash
make rector
```

Validate composer.json:

```bash
make validate
```

Run all checks (validate, rector-dry, test):

```bash
make check
```

### Available Make Commands

Run `make help` to see all available commands:

```bash
make help
```

### Project Structure

```
.
├── src/
│   ├── GoogleDriveProvider.php           # Main provider implementation
│   └── GoogleDriveConfigurationManager.php # Configuration management
├── tests/
│   ├── GoogleDriveProviderTest.php
│   └── GoogleDriveConfigurationManagerTest.php
├── .github/
│   └── workflows/
│       └── ci.yml                         # GitHub Actions CI configuration
├── composer.json
├── phpunit.xml                            # PHPUnit configuration
├── rector.php                             # Rector configuration for PHP 8.4
├── Makefile                               # Development commands
└── README.md
```

## Testing

The package includes comprehensive unit tests. Run them with:

```bash
vendor/bin/phpunit
```

Or using make:

```bash
make test
```

## Continuous Integration

This package uses GitHub Actions for continuous integration. The CI pipeline:

- Validates composer.json
- Installs dependencies
- Runs Rector checks
- Executes all tests

See `.github/workflows/ci.yml` for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Credits

- [Samuel Vicent](https://github.com/samuelvi)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
