<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;

class TaphouseScraper extends AbstractScraper
{
    private string $url = 'https://taphouse.dk/';

    public function scrape(): void
    {
        foreach ($this->scrapeList($this->url, '#beerTable tbody tr') as $node) {
            $tapName = $node->filter('.tapNumber')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->filter('a.untappdLink')->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        }
    }
}
