<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public $timestamps = false;

    public function parent() 
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function films()
    {
        return $this->belongsToMany(Film::class, 'category_films');
    }


}
