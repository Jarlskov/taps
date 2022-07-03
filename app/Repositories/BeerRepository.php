<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Beer;
use App\Models\Brewery;

class BeerRepository
{
    public function findByUntappdId(int $untappdId): ?Beer
    {
        return Beer::where(['untappd_id' => $untappdId])->first();
    }

    public function findByNameAndBrewery(string $name, Brewery $brewery): ?Beer
    {
        return Beer::where(['name' => $name, 'brewery_id' => $brewery->id])->first();
    }
}
