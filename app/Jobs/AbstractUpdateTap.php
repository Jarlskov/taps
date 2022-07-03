<?php

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
use Jarlskov\Untappd\Models\Beer as UntappdBeer;
use Jarlskov\Untappd\Models\Brewery as UntappdBrewery;
use Jarlskov\Untappd\Untappd;

abstract class AbstractUpdateTap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BeerRepository $beerRepository;
    protected BreweryRepository $breweryRepository;
    protected int $tapId;
    protected Untappd $untappd;
    protected UntappdMapper $untappdMapper;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tap $tap)
    {
        $this->tapId = $tap->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        BeerRepository $beerRepository,
        BreweryRepository $breweryRepository,
        Untappd $untappd,
        UntappdMapper $mapper
    ) {
        $this->beerRepository = $beerRepository;
        $this->breweryRepository = $breweryRepository;
        $this->untappd = $untappd;
        $this->untappdMapper = $mapper;

        $beer = $this->getBeer();
        if (!is_null($beer)) {
            Tap::find($this->tapId)
                ->putOn($beer);
        } else {
        }
    }

    protected function findOrMapBrewery(UntappdBrewery $untappdBrewery)
    {
        $brewery = $this->breweryRepository->findByUntappdId($untappdBrewery->getBreweryId());
        if (!$brewery) {
            $brewery = $this->createBrewery($untappdBrewery);
        }

        return $brewery;
    }

    protected function mapBeer(UntappdBeer $untappdBeer, Brewery $brewery)
    {
        $beer = $this->untappdMapper->mapBeer($untappdBeer);
        $beer->brewery()->associate($brewery);
        $beer->save();

        return $beer;
    }

    private function createBrewery(UntappdBrewery $untappdBrewery): Brewery
    {
        $country = Country::firstOrCreate(['name' => $untappdBrewery->getCountryName()]);
        $brewery = $this->untappdMapper->mapBrewery($untappdBrewery);
        $brewery->country()->associate($country);
        $brewery->save();

        return $brewery;
    }

    protected abstract function getBeer(): ?Beer;
}
