<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActorsFilmsResource;
use App\Http\Resources\ActorsResource;
use App\Http\Resources\FilmResource;
use App\Http\Resources\ReviewResource;
use App\Models\Actor;
use App\Models\ActorFilm;
use App\Models\Actors_films;
use App\Models\Favorites;
use App\Models\Film;
use App\Models\Likes;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 30);
        $sortBy = $request->query('sortBy', 'name');
        $sortDir = $request->query('sortDir', 'asc');

        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        $films = Film::query();

        if ($sortBy === 'name') {
            $films = $films->orderBy($sortBy, $sortDir);
        }
        elseif ($sortBy === 'year') {
            $films = $films->orderBy('year_of_issue', $sortDir);
        }
        elseif ($sortBy === 'rating') {
            $films = $films
            ->withAvg('ratings', 'ball')
            ->orderBy('ratings_avg_ball', $sortDir);
        }

        if ($request->has('search')) {
            $films = $films->where('name', 'like', '%' . $request->query('search') . '%');
        }
        if ($request->has('country')) {
            $films = $films->where('country_id', $request->query('country'));
        }
        if ($request->has('category')) {
            $categories = explode('%', $request->query('category'));

            $films = $films->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }


        $films = $films->paginate($size);

        return response([
            'page' => $films->currentPage(),
            'size' => $films->perPage(),
            'total' => $films->total(),
            'films' => FilmResource::collection($films),
        ]);
    }

    public function show($id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        return response (new FilmResource($film));
    }

    public function reviews($filmId, Request $request)
    {
        $film = Film::find($filmId);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        $reviews = $film->reviews()->where('is_approved', 1)->with(['user' => function ($query) {
            $query->withTrashed();
        }])->get();

        foreach ($reviews as $review) {
            $review->likesCount = Likes::where('review_id', $review->id)->where('like', 1)->count();
        }

        return response()->json([
            'reviews' => ReviewResource::collection($reviews)
        ]);
    }

    public function favorites($filmId, Request $request)
    {
        $likesCount = Favorites::where('film_id', $filmId)->count();

        return response()->json(['likes_count' => $likesCount]);
    }

    public function actors(Request $request, $film_id)
    {
        $actors_ids = ActorFilm::where('film_id', $film_id)->pluck('actor_id');
        $actors = Actor::whereIn('id', $actors_ids)->get();

        return response()->json([
            'actors' => ActorsResource::collection($actors)
        ]);
    }

}