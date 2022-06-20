<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Brewery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'untappd_id',
    ];

    public function beers(): Relation
    {
        return $this->hasMany(Beer::class);
    }

    public function country(): Relation
    {
        return $this->belongsTo(Country::class);
    }
}
