<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Bar extends Model
{
    use HasFactory;

    public function getOrCreateTapByName($name): Tap
    {
        $tap = $this->taps()->where(['name' => $name])->first();
        if (!$tap) {
            $tap = new Tap();
            $tap->name = $name;
            $this->taps()->save($tap);
        }

        return $tap;
    }

    public function taps(): Relation
    {
        return $this->hasMany(Tap::class);
    }

    public function updateTaplist()
    {
        $scraper = new $this->class($this);
        $scraper->scrape();
    }
}
