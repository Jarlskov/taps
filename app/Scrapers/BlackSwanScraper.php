<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByBeerName;
use Symfony\Component\DomCrawler\Crawler;

class BlackSwanScraper extends AbstractScraper
{
    private string $url = 'http://www.blackswanbar.dk/beer';

    public function scrape(): void
    {
        $tapNumber = 1;
        foreach ($this->scrapeList($this->url) as $node) {
            $tap = $this->bar->getOrCreateTapByName((string) $tapNumber);

            $breweryName = $node->filter('td')->first()->text();
            $beerName = $node->filter('a')->first()->text();
            UpdateTapByBeerName::dispatch($tap, $beerName, $breweryName);
            $tapNumber++;
        }
    }

    protected function filterPage(Crawler $crawler): Crawler
    {
        return $crawler->filter('table tbody try')->first();
    }
}
