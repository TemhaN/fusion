<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActorFilm extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function actor()
    {
        return $this->belongsTo(Actor::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
    protected $fillable = [
        'actor_id',
        'film_id',
    ];


}