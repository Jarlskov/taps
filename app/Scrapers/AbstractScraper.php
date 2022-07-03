<?php

declare(strict_types=1);

namespace App\Scrapers;

use App\Models\Bar;
use HeadlessChromium\BrowserFactory;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractScraper implements ScraperInterface
{
    protected Bar $bar;
    protected string $tableQuery;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    protected function scrapeList(string $url): array
    {
        return $this->filterPage($this->getCrawler($url))
             ->each(function ($node) {
                 return $node;
             });
    }

    protected function filterPage(Crawler $crawler): Crawler
    {
        return $crawler
            ->filter($this->tableQuery);
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
