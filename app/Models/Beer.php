<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Beer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label_url',
        'label_url_hd',
        'abv',
        'ibu',
        'description',
        'rating_count',
        'rating_score',
        'untappd_id',
    ];

    public function brewery(): Relation
    {
        return $this->belongsTo(Brewery::class);
    }

    public function taps(): Relation
    {
        return $this->hasMany(TapBeer::class);
    }
}
