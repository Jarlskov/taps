<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\UpdateTapByUntappdId;
use App\Models\Bar;
use HeadlessChromium\BrowserFactory;
use Symfony\Component\DomCrawler\Crawler;

class FermentorenScraper implements ScraperInterface
{
    private Bar $bar;
    private string $client;
    private string $url = 'https://fermentoren.com/';

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    public function scrape()
    {
        $page = (new BrowserFactory())->createBrowser()->createPage();
        $page->navigate($this->url)->waitForNavigation();
        $crawler = new Crawler($page->getHtml());
        // Iterate through each beer on the menu
        $crawler->filter('.item .item-name a')->each(function ($node) {
            $tapName = $node->filter('.tap-number-hideable')->first()->text();
            $tap = $this->bar->getOrCreateTapByName($tapName);

            $untappdId = $this->getIdFromUrl($node->attr('href'));
            UpdateTapByUntappdId::dispatch($tap, $untappdId);
        });
    }

    private function getIdFromUrl(string $url): int
    {
        $urlParts = explode('/', $url);
        return (int) $urlParts[count($urlParts) - 1];
    }
}
