<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;
use Symfony\Component\DomCrawler\Crawler;

class OelbarenScraper extends AbstractScraper
{
    protected string $tableQuery = '#beerTable tr';
    protected string $url = 'https://oelbaren.dk/oel/';

    protected function handleNode(int $index, Crawler $node): void
    {
        $tapName = $node->filter('.tapnumber')->first()->text();
        $tap = $this->bar->getOrCreateTapByName($tapName);

        $untappdId = $this->getIdFromUrl($node->filter('a')->attr('href'));
        UpdateTapByUntappdId::dispatch($tap, $untappdId);
    }
}
