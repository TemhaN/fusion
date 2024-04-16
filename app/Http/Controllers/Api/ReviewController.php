<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Film;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($filmId, Request $request)
    {
        $film = Film::find($filmId);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        $reviews = $film->reviews()->where('is_approved', true)->get();

        if ($request->has('search')) {
            $searchTerms = explode('%', $request->query('search'));
            foreach ($searchTerms as $searchTerm) {
                $reviews = $reviews->where(function ($query) use ($searchTerm) {
                    $query->where('message', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('user', function ($query) use ($searchTerm) {
                            $query->where('fio', 'like', '%' . $searchTerm . '%');
                        });
                });
            }
        }

        return response()->json([
            'reviews' => ReviewResource::collection($reviews)
        ], 200);
    }

}
