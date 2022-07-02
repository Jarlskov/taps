<?php

declare(strict_types=1);

namespace App\Scrapers;

interface ScraperInterface
{
    public function scrape(): void;
}
