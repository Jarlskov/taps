<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tap extends Model
{
    use HasFactory;

    protected $casts = [
        'on_from' => 'datetime',
        'on_to' => 'datetime',
    ];

    public function putOn(Beer $beer): void
    {
        $current = $this->getCurrent();
        if ($current && $current->beer->is($beer)) {
            return;
        }

        if ($current) {
            $current->on_to = new \DateTime();
            $current->save();
        }

        $current = new TapBeer();
        $current->on_from = new \DateTime;
        $current->beer()->associate($beer);
        $current->tap()->associate($this);

        $current->save();
    }

    public function getCurrent(): ?TapBeer
    {
        return TapBeer::where('tap_id', $this->id)
            ->where('on_to', null)
            ->first();
    }

    public function bar(): BelongsTo
    {
        return $this->belongsTo(Bar::class);
    }

    public function beer(): HasMany
    {
        return $this->hasMany(TapBeer::class);
    }
}
