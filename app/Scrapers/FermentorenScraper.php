<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;

class FermentorenScraper extends AbstractScraper
{
    private string $url = 'https://fermentoren.com/';

    public function scrape(): void
    {
        $crawler = $this->getCrawler($this->url);
        // Iterate through each beer on the menu
        $crawler->filter('.item .item-name a')->each(function ($node) {
            $tapName = $node->filter('.tap-number-hideable')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        });
    }
}
