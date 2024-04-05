<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFilm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    protected $fillable = [
        'category_id',
        'film_id',
    ];
}
