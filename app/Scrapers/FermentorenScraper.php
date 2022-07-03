<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;

class FermentorenScraper extends AbstractScraper
{
    protected string $tableQuery = '.item .item-name a';
    private string $url = 'https://fermentoren.com/';

    public function scrape(): void
    {
        foreach ($this->scrapeList($this->url) as $node) {
            $tapName = $node->filter('.tap-number-hideable')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        }
    }
}
