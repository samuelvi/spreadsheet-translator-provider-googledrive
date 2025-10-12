<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Provider\GoogleDrive;

use Exception;
use GuzzleHttp\Client;
use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Core\Provider\ProviderInterface;
use Atico\SpreadsheetTranslator\Core\Resource\Resource;

class GoogleDriveProvider implements ProviderInterface
{
    protected GoogleDriveConfigurationManager $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = new GoogleDriveConfigurationManager($configuration);
    }

    public function getProvider(): string
    {
        return 'google_drive';
    }

    public function handleSourceResource(): Resource
    {
        $format = $this->configuration->getFormat();
        $sourceResource = $this->configuration->getSourceResource();
        $tempLocalResource = $this->configuration->getTempLocalSourceFile();

        $documentId = $this->getDocumentIdFromUrl($sourceResource);

        $url = sprintf('https://docs.google.com/spreadsheets/d/%s/export?format=%s&id=%s', $documentId, $format, $documentId);

        $this->downloadFileFromUrlByGuzzleHttp($url, $tempLocalResource);
        return new Resource($tempLocalResource, $format);
    }

    protected function getDocumentIdFromUrl($url): string
    {
        $portions = explode('/', (string) $url);
        foreach ($portions as $index => $portion) {
            if ($portion === 'd') {
                return $portions[$index + 1];
            }
        }
        throw new Exception(sprintf('Document Id not found in the url: "$url"', $url));
    }

    private function downloadFileFromUrlByGuzzleHttp(string $url, $tempLocalResource): void
    {
        $guzzleHttpClient = new Client();
        $guzzleHttpClient->get($url, ['save_to' => $tempLocalResource]);
    }
}