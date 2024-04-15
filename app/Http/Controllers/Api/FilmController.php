<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 5);
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

        return new FilmResource($film);
    }

}
