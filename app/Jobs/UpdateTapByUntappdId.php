<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Beer;
use App\Models\Brewery;
use App\Models\Tap;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

    protected function getBeer(): ?Beer
    {
        $beer = $this->beerRepository->findByUntappdId($this->untappdId);
        if ($beer) {
            return $beer;
        }

        $untappdBeer = $this->untappd->getBeer($this->untappdId);
        $brewery = $this->findOrMapBrewery($untappdBeer->getBrewery());

        return $this->mapBeer($untappdBeer, $brewery);
    }
}
