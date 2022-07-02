<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Models\Bar;
use HeadlessChromium\BrowserFactory;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractScraper implements ScraperInterface
{
    protected Bar $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    protected function scrapeList(string $url, string $query): Node
    {
        $crawler = $this->getCrawler($url);
        $crawler->filter($query)->each(function ($node) {
            dd($node);
            yield $node;
        });
        dd('k');
    }

    protected function getCrawler(String $url): Crawler
    {
        $page = (new BrowserFactory())->createBrowser()->createPage();
        $page->navigate($url)->waitForNavigation();
        return new Crawler($page->getHtml());
    }

    protected function getIdFromUrl(string $url): int
    {
        $urlParts = explode('/', $url);
        return (int) $urlParts[count($urlParts) - 1];
    }
}