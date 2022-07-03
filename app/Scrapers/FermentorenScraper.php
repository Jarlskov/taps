<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;
use Symfony\Component\DomCrawler\Crawler;

class FermentorenScraper extends AbstractScraper
{
    protected string $tableQuery = '.item .item-name a';
    protected string $url = 'https://fermentoren.com/';

    protected function handleNode(int $index, Crawler $node): void
    {
        $tapName = $node->filter('.tap-number-hideable')->first()->text();
        $tap = $this->bar->getOrCreateTapByName($tapName);

        $untappdId = $this->getIdFromUrl($node->attr('href'));
        UpdateTapByUntappdId::dispatch($tap, $untappdId);
    }
}
