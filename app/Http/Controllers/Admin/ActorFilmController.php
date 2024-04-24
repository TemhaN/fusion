<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActorFilmRequest;
use App\Models\Actor;
use App\Models\ActorFilm;
use App\Models\Film;
use Illuminate\Http\Request;

class ActorFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actorsfilm = ActorFilm::with('actor')->get();
        $films = Film::all();
        $actors = Actor::all();
        return view('admins.actorfilm.index', compact('actorsfilm', 'films', 'actors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $actors = Actor::all();
        $films = Film::all();

        return view('admins.actorfilm.create', compact('films', 'actors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActorFilmRequest $request)
    {
        ActorFilm::create($request->validated());

        return redirect(route('actorfilms.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actorfilm = ActorFilm::findOrFail($id);
        $actorfilm->film_id = $request->film_id;
        $actorfilm->actor_id = $request->actor_id;
        $actorfilm->save();

        return back()->with('success', 'ActorFilm updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActorFilm $actorfilm)
    {
        $actorfilm->delete();

        return back();
    }
}
