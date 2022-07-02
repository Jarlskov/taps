<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Bar;
use Illuminate\Console\Command;

class UpdateTapLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taplists:update {bar?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all taplists';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $barName = $this->argument('bar');
        if ($barName) {
            $bar = Bar::where('name', $barName)->firstOrFail();
            $bar->updateTaplist();

            return 1;
        }

        foreach (Bar::all() as $bar) {
            $bar->updateTaplist();
        }

        return 1;
    }
}
