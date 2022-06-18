<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Jobs\FetchUntappdBeer;
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
        $crawler->filter('.item .item-name a')->each(function ($node) {
            $urlParts = explode('/', $node->attr('href'));
            $untappdId = (int) $urlParts[count($urlParts) - 1];
            FetchUntappdBeer::dispatch($this->bar, $untappdId);
        });
    }
}
