<?php

declare(strict_types=1);

namespace Atico\SpreadsheetTranslator\Provider\GoogleDrive\Tests;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Provider\GoogleDrive\GoogleDriveProvider;
use PHPUnit\Framework\TestCase;

class GoogleDriveProviderTest extends TestCase
{
    public function testSupports(): void
    {
        $configuration = new Configuration([], [
            'provider' => 'google_drive',
            'source_resource' => 'https://docs.google.com/spreadsheets/d/12345/edit#gid=0',
            'temp_local_source_file' => '/tmp/test.csv',
            'format' => 'csv',
        ]);
        $provider = new GoogleDriveProvider($configuration);
        $this->assertEquals('google_drive', $provider->getProvider());
    }
}
