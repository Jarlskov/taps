<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mappers\UntappdMapper;
use App\Models\Beer;
use App\Models\Brewery;
use App\Models\Country;
use App\Models\Tap;
use App\Repositories\BeerRepository;
use App\Repositories\BreweryRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jarlskov\Untappd\Untappd;
use Jarlskov\Untappd\Models\Brewery as UntappdBrewery;

class UpdateTapByUntappdId extends AbstractUpdateTap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $untappdId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tap $tap, int $untappdId)
    {
        parent::__construct($tap);
        $this->untappdId = $untappdId;
    }

    protected function getBeer(
        BeerRepository $beerRepository,
        BreweryRepository $breweryRepository,
        Untappd $untappd,
        UntappdMapper $mapper
    ): Beer {
        $beer = $beerRepository->findByUntappdId($this->untappdId);
        if ($beer) {
            return $beer;
        }

        $untappdBeer = $untappd->getBeer($this->untappdId);
        $brewery = $breweryRepository->findByUntappdId($untappdBeer->getBrewery()->getBreweryId());
        if (!$brewery) {
            $brewery = $this->createBrewery($untappdBeer->getBrewery(), $mapper);
        }
        $beer = $mapper->mapBeer($untappdBeer);
        $beer->brewery()->associate($brewery);
        $beer->save();

        return $beer;
    }

    private function createBrewery(UntappdBrewery $untappdBrewery, UntappdMapper $mapper): Brewery
    {
        $country = Country::firstOrCreate(['name' => $untappdBrewery->getCountryName()]);
        $brewery = $mapper->mapBrewery($untappdBrewery);
        $brewery->country()->associate($country);
        $brewery->save();

        return $brewery;
    }
}
