<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByBeerName;
use Symfony\Component\DomCrawler\Crawler;

class BlackSwanScraper extends AbstractScraper
{
    protected string $url = 'http://www.blackswanbar.dk/beer';

    protected function handleNode(int $index, Crawler $node): void
    {
        $tap = $this->bar->getOrCreateTapByName((string) ($index + 1));

        $breweryName = $node->filter('td')->first()->text();
        $beerName = $node->filter('a')->first()->text();
        UpdateTapByBeerName::dispatch($tap, $beerName, $breweryName);
    }

    protected function filterPage(Crawler $crawler): Crawler
    {
        return $crawler->filter('table tbody')->first();
    }
}
