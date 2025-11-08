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

use Override;
use Atico\SpreadsheetTranslator\Core\Configuration\ProviderConfigurationInterface;
use Atico\SpreadsheetTranslator\Core\Provider\DefaultProviderManager;

class GoogleDriveConfigurationManager extends DefaultProviderManager implements ProviderConfigurationInterface
{
    #[Override]
    public function getSourceResource(): string
    {
        return parent::getSourceResource();
    }

    public function getPublicUrl(): string
    {
        $sourceResource = $this->getSourceResource();
        $spreadsheetId = $this->getSpreadsheetIdFromUrl($sourceResource);
        $sheetId = $this->getSheetIdFromUrl($sourceResource);
        return sprintf('https://docs.google.com/spreadsheets/d/%s/export?format=csv&gid=%s', $spreadsheetId, $sheetId);
    }

    private function getSpreadsheetIdFromUrl(string $url): string
    {
        $matches = [];
        preg_match('/spreadsheets\/d\/([a-zA-Z0-9-_]+)/', $url, $matches);
        return $matches[1] ?? '';
    }

    private function getSheetIdFromUrl(string $url): string
    {
        $matches = [];
        preg_match('/gid=(\d+)/', $url, $matches);
        return $matches[1] ?? '';
    }
}