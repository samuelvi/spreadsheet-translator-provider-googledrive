<?php

declare(strict_types=1);

namespace Atico\SpreadsheetTranslator\Provider\GoogleDrive\Tests;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Provider\GoogleDrive\GoogleDriveProvider;
use PHPUnit\Framework\TestCase;

class GoogleDriveProviderTest extends TestCase
{
    private function createConfiguration(array $options = []): Configuration
    {
        $defaults = [
            'provider' => 'google_drive',
            'source_resource' => 'https://docs.google.com/spreadsheets/d/12345/edit#gid=0',
            'temp_local_source_file' => '/tmp/test.csv',
            'format' => 'csv',
        ];

        $configData = [
            'en' => [
                'google_drive' => array_merge($defaults, $options)
            ]
        ];

        return new Configuration($configData, 'google_drive');
    }

    public function testGetProviderReturnsCorrectName(): void
    {
        $provider = new GoogleDriveProvider($this->createConfiguration());
        $this->assertEquals('google_drive', $provider->getProvider());
    }

    public function testConstructorCreatesConfigurationManager(): void
    {
        $configuration = $this->createConfiguration();
        $provider = new GoogleDriveProvider($configuration);

        $this->assertInstanceOf(GoogleDriveProvider::class, $provider);
    }
}
