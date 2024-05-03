<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilmRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Country;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::all();
        $categories = Category::all();

        return view('admins.films.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Film $film)
    {

        $film = Film::all();

	    $countries = Country::all();
		$categories = Category::all();

        return view('admins.films.create' , compact('countries', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmRequest $request)
    {
        $data = $request->validated();

        Film::create($data);
        return redirect(route('films.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        $films = Film::all();
	    $countries = Country::all();
		$categories = Category::all();

        return view('admins.films.create' , compact('film', 'countries', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmRequest $request, string $id)
    {
        $film = Film::findOrFail($id);
        $film->update($request->validated());
        return redirect(route('films.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return redirect(route('films.index'));
    }

}