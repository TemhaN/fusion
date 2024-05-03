<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Rating;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getTopRatedFilmLink()
    {
        $topRatedFilms = Rating::orderBy('ball', 'desc')->take(10)->pluck('film_id');

        $randomFilmId = $topRatedFilms->random();

        $film = Film::find($randomFilmId);
        $linkVideo = $film->link_video;

        return response()->json(['link_video' => $linkVideo]);
    }

    public function getTopRatedFilmList()
    {
        $topRatedFilmsIds = Rating::orderBy('ball', 'desc')->take(10)->pluck('film_id');

        $topRatedFilms = Film::whereIn('id', $topRatedFilmsIds)->get();

        return response()->json(['films' => $topRatedFilms]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}