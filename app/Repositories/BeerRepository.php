<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Beer;

class BeerRepository
{
    public function findByUntappdId(int $untappdId): ?Beer
    {
        return Beer::where(['untappd_id' => $untappdId])->first();
    }
}
