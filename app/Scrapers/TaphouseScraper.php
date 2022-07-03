<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;
use Symfony\Component\DomCrawler\Crawler;

class TaphouseScraper extends AbstractScraper
{
    protected string $tableQuery = '#beerTable tbody tr';
    protected string $url = 'https://taphouse.dk/';

    protected function handleNode(int $index, Crawler $node): void
    {
        $tapName = $node->filter('.tapNumber')->first()->text();
        $tap = $this->bar->getOrCreateTapByName($tapName);

        $untappdId = $this->getIdFromUrl($node->filter('a.untappdLink')->attr('href'));
        UpdateTapByUntappdId::dispatch($tap, $untappdId);
    }
}
