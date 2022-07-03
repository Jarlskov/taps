<?php

namespace App\Jobs;

use App\Mappers\UntappdMapper;
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

abstract class AbstractUpdateTap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $tapId;

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
        $beer = $this->getBeer($beerRepository, $breweryRepository, $untappd, $mapper);
        if (!is_null($beer)) {
            Tap::find($this->tapId)
                ->putOn($beer);
        } else {
        }
    }
}
