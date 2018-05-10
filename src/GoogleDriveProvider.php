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

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Core\Provider\ProviderInterface;
use Atico\SpreadsheetTranslator\Core\Resource\Resource;
use Atico\SpreadsheetTranslator\Core\Util\Curl;
use GuzzleHttp;

class GoogleDriveProvider implements ProviderInterface
{
    /** @var GoogleDriveConfigurationManager $configuration */
    protected $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = new GoogleDriveConfigurationManager($configuration);
    }

    public function getProvider()
    {
        return 'google_drive';
    }

    public function handleSourceResource()
    {
        $format = $this->configuration->getFormat();
        $sourceResource = $this->configuration->getSourceResource();
        $tempLocalResource = $this->configuration->getTempLocalSourceFile();

        $documentId = $this->getDocumentIdFromUrl($sourceResource);

        $url = sprintf('https://docs.google.com/spreadsheets/d/%s/export?format=%s&id=%s', $documentId, $format, $documentId);

        self::downloadFileFromUrlByGuzzleHttp($url, $tempLocalResource);
        return new Resource($tempLocalResource, $format);
    }

    protected function getDocumentIdFromUrl($url)
    {
        $portions = explode('/', $url);
        foreach ($portions as $index => $portion) {
            if ($portion == 'd') return $portions[$index + 1];
        }
        throw new \Exception(sprintf('Document Id not found in the url: "$url"', $url));
    }

    private static function downloadFileFromUrlByGuzzleHttp($url, $tempLocalResource)
    {
        $guzzleHttpClient = new GuzzleHttp\Client();
        $guzzleHttpClient->get($url, ['save_to' => $tempLocalResource]);
    }

    private static function downloadFileFromUrlByCurl($url, $tempLocalResource)
    {
        $content = Curl::get($url);
        file_put_contents($tempLocalResource, $content);
    }

    private static function downloadFileFromUrlByGuzzleHttpLongWay($url, $tempLocalResource)
    {
        $params = array('timeout' => 10, 'connect_timeout' => 10);
        $client = new GuzzleHttp\Client();

        // send request / get response
        $response = $client->get($url, $params);

        // this is the response body from the requested page (usually html)
        $result = $response->getBody();
        file_put_contents($tempLocalResource, $result, FILE_BINARY);

    }
}