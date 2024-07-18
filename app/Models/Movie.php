<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'movies';

    protected $fillable = [
        'title',
        'summary',
        'poster',
        'year',
        'genre_id'
    ];

    public function listCasts()
    {
        return $this->belongsToMany(Cast::class, 'cast_movies', 'movie_id', 'cast_id');
    }
}
