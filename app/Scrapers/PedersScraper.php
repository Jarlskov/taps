<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;

class PedersScraper extends AbstractScraper
{
    private string $url = 'https://pederscph.dk/';

    public function scrape(): void
    {
        foreach ($this->scrapeList($this->url, '#menu-10216 .menu-item .item') as $node) {
            $tapName = $node->filter('.tap-number-hideable')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->filter('a.item-title-color')->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        }
    }
}
