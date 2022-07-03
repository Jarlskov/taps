<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByBeerName;

class BlackSwanScraper extends AbstractScraper
{
    private string $url = 'http://www.blackswanbar.dk/beer';

    public function scrape(): void
    {
        $i = 1;
        foreach ($this->scrapeList($this->url, 'table tbody tr') as $node) {
            $tap = $this->bar->getOrCreateTapByName((string) $i);

            $breweryName = $node->filter('td')->first()->text();
            $beerName = $node->filter('a')->first()->text();
            UpdateTapByBeerName::dispatch($tap, $beerName, $breweryName);
            $i++;
        }
    }
}
