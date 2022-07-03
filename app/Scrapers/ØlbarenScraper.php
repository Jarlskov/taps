<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;

class ØlbarenScraper extends AbstractScraper
{
    private string $url = 'https://oelbaren.dk/oel/';

    public function scrape(): void
    {
        foreach ($this->scrapeList($this->url, '#beerTable tr') as $node) {
            $tapName = $node->filter('.tapnumber')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->filter('a')->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        }
    }
}
