<?php

namespace App\Jobs;

use App\Models\Bar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jarlskov\Untappd\Untappd;

class FetchUntappdBeer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $barId;
    private int $beerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Bar $bar, int $beerId)
    {
        $this->barId = $bar->id;
        $this->beerId = $beerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Untappd $untappd)
    {
        $beer = $untappd->getBeer($this->beerId);
    }
}
