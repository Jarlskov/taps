<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Brewery;

class BreweryRepository
{
    public function findByUntappdId(int $untappdId): ?Brewery
    {
        return Brewery::where(['untappd_id' => $untappdId])->first();
    }
}
