<?php

declare(strict_types=1);

namespace Atico\SpreadsheetTranslator\Provider\GoogleDrive\Tests;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Provider\GoogleDrive\GoogleDriveConfigurationManager;
use PHPUnit\Framework\TestCase;

class GoogleDriveConfigurationManagerTest extends TestCase
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

    public function testGetPublicUrlWithValidSpreadsheetUrl(): void
    {
        $configuration = $this->createConfiguration([
            'source_resource' => 'https://docs.google.com/spreadsheets/d/12345/edit#gid=67890'
        ]);

        $configurationManager = $this->getMockBuilder(GoogleDriveConfigurationManager::class)
            ->setConstructorArgs([$configuration])
            ->onlyMethods(['getSourceResource'])
            ->getMock();

        $configurationManager->method('getSourceResource')
            ->willReturn('https://docs.google.com/spreadsheets/d/12345/edit#gid=67890');

        $url = $configurationManager->getPublicUrl();

        $this->assertEquals(
            'https://docs.google.com/spreadsheets/d/12345/export?format=csv&gid=67890',
            $url
        );
    }

    public function testGetPublicUrlExtractsSpreadsheetId(): void
    {
        $configuration = $this->createConfiguration([
            'source_resource' => 'https://docs.google.com/spreadsheets/d/ABC123XYZ/edit#gid=0'
        ]);

        $configurationManager = $this->getMockBuilder(GoogleDriveConfigurationManager::class)
            ->setConstructorArgs([$configuration])
            ->onlyMethods(['getSourceResource'])
            ->getMock();

        $configurationManager->method('getSourceResource')
            ->willReturn('https://docs.google.com/spreadsheets/d/ABC123XYZ/edit#gid=0');

        $url = $configurationManager->getPublicUrl();

        $this->assertStringContainsString('ABC123XYZ', $url);
        $this->assertStringContainsString('gid=0', $url);
    }

    public function testGetSourceResourceCallsParent(): void
    {
        $expectedUrl = 'https://docs.google.com/spreadsheets/d/test123/edit#gid=0';
        $configuration = $this->createConfiguration([
            'source_resource' => $expectedUrl
        ]);

        $configurationManager = new GoogleDriveConfigurationManager($configuration);

        $this->assertEquals($expectedUrl, $configurationManager->getSourceResource());
    }
}
