<?php

namespace App\Jobs;

use App\Models\Beer;
use App\Models\Tap;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jarlskov\Untappd\Models\Beer as UntappdBeer;
use Jarlskov\Untappd\Models\SearchRequest;
use stdClass;

class UpdateTapByBeerName extends AbstractUpdateTap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $beerName;
    private string $breweryName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tap $tap, string $beerName, string $breweryName)
    {
        parent::__construct($tap);
        $this->beerName = $beerName;
        $this->breweryName = $breweryName;
    }

    protected function getBeer(): ?Beer
    {
        $beer = $this->findExistingBeer();
        if ($beer) {
            return $beer;
        }

        return $this->searchUntappd();
    }

    private function searchUntappd(): ?Beer
    {
        $search = new SearchRequest();
        $search->setBeerName($this->beerName);
        $search->setBreweryName($this->breweryName);

        $result = $this->untappd->beerSearch($search);
        if (!count($result)) {
            return null;
        }

        foreach ($result as $r) {
            if ($r->getBeerName() == $this->beerName && $r->getbrewery()->getBreweryName() == $this->breweryName) {
                return $this->createBeer($r);
            }
        }

        return $this->createBeer($result[0]);
    }

    private function createBeer(UntappdBeer $result)
    {
        $brewery = $this->findOrMapBrewery($result->getBrewery());

        return $this->mapBeer($result, $brewery);
    }

    private function findExistingBeer(): ?Beer
    {
        $brewery = $this->breweryRepository->findByName($this->breweryName);
        if (!$brewery) {
            return null;
        }

        $beer = $this->beerRepository->findByNameAndBrewery($this->beerName, $brewery);

        return $beer;
    }
}
