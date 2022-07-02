<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;

class ØlbarenScraper extends AbstractScraper
{
    private string $url = 'https://oelbaren.dk/oel/';

    public function scrape(): void
    {
        $crawler = $this->getCrawler($this->url);
        // Iterate through each beer on the menu
        $crawler->filter('#beerTable tr')->each(function ($node) {
            $tapName = $node->filter('.tapnumber')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->filter('a')->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        });
    }
}
