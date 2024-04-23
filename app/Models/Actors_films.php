<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actors_films extends Model
{
    use HasFactory;

    protected $table = 'actors_films';

    protected $fillable = [
        'actors_id',
        'film_id',
    ];

    public function actors()
    {
        return $this->belongsTo(Actor::class, 'actors_id');
    }

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

}
