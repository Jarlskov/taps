<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Brewery;

class BreweryRepository
{
    public function findByUntappdId(int $id): ?Brewery
    {
        return Brewery::where(['untappd_id' => $id])->first();
    }
}
