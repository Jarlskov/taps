<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Models\Beer;
use App\Models\Brewery;
use App\Models\Country;
use App\Repositories\BreweryRepository;
use Jarlskov\Untappd\Models\Beer as UntappdBeer;
use Jarlskov\Untappd\Models\Brewery as UntappdBrewery;

class UntappdMapper
{
    public function __construct()
    {
    }

    public function mapBeer(UntappdBeer $untappdBeer): Beer
    {
        $beer = new Beer([
            'name' => $untappdBeer->getBeerName(),
            'label_url' => $untappdBeer->getBeerLabel(),
            'label_url_hd' => $untappdBeer->getBeerLabel(),
            'abv' => $untappdBeer->getBeerAbv(),
            'ibu' => $untappdBeer->getBeerIbu(),
            'description' => $untappdBeer->getBeerDescription(),
            'rating_count' => $untappdBeer->getRatingCount(),
            'rating_score' => $untappdBeer->getRatingScore(),
            'untappd_id' => $untappdBeer->getBid(),
        ]);

        return $beer;
    }

    public function mapBrewery(UntappdBrewery $untappdBrewery): Brewery
    {
        $brewery = new Brewery([
            'name' => $untappdBrewery->getBreweryName(),
            'untappd_id' => $untappdBrewery->getBreweryId(),
        ]);

        return $brewery;
    }
}
