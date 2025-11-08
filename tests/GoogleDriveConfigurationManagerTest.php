<?php

declare(strict_types=1);

namespace Atico\SpreadsheetTranslator\Provider\GoogleDrive\Tests;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Provider\GoogleDrive\GoogleDriveConfigurationManager;
use PHPUnit\Framework\TestCase;

class GoogleDriveConfigurationManagerTest extends TestCase
{
    public function testGetPublicUrl(): void
    {
        $configuration = new Configuration([], []);
        $configurationManager = $this->getMockBuilder(GoogleDriveConfigurationManager::class)
            ->setConstructorArgs([$configuration])
            ->onlyMethods(['getSourceResource'])
            ->getMock();

        $configurationManager->method('getSourceResource')->willReturn('https://docs.google.com/spreadsheets/d/12345/edit#gid=67890');

        $url = $configurationManager->getPublicUrl();
        $this->assertEquals(
            'https://docs.google.com/spreadsheets/d/12345/export?format=csv&gid=67890',
            $url
        );
    }
}
