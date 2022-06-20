<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class TapBeer extends Model
{
    use HasFactory;

    public function tap(): Relation
    {
        return $this->belongsTo(Tap::class);
    }

    public function beer(): Relation
    {
        return $this->belongsTo(Beer::class);
    }
}
