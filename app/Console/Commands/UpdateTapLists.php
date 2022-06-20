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
    protected $signature = 'taplists:update';

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
        foreach (Bar::all() as $bar) {
            $bar->updateTaplist();
        }
    }
}
