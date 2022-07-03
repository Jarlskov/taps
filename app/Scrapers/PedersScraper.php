<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;
use Symfony\Component\DomCrawler\Crawler;

class PedersScraper extends AbstractScraper
{
    protected string $tableQuery = '#menu-10216 .menu-item .item';
    protected string $url = 'https://pederscph.dk/';

    protected function handleNode(int $index, Crawler $node): void
    {
        $tapName = $node->filter('.tap-number-hideable')->first()->text();
        $tap = $this->bar->getOrCreateTapByName($tapName);

        $untappdId = $this->getIdFromUrl($node->filter('a.item-title-color')->attr('href'));
        UpdateTapByUntappdId::dispatch($tap, $untappdId);
    }
}
