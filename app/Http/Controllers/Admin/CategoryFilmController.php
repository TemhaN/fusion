<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFilmRequest;
use App\Models\Category;
use App\Models\CategoryFilm;
use App\Models\Film;
use Illuminate\Http\Request;

class CategoryFilmController extends Controller
{
    /**
     * Display a listing of the resource.
        */
    public function index()
    {
        $categriesfilm = CategoryFilm::with('category')->get();
        $films = Film::all();
        $categories = Category::all();
        return view('admins.categoryfilm.index', compact('categriesfilm', 'films', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $films = Film::all();

        return view('admins.categoryfilm.create', compact('films', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFilmRequest $request)
    {
        CategoryFilm::create($request->validated());

        return redirect(route('categoryfilms.index'));
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
        $categoryfilm = CategoryFilm::findOrFail($id);
        $categoryfilm->film_id = $request->film_id;
        $categoryfilm->category_id = $request->category_id;
        $categoryfilm->save();

        return back()->with('success', 'CategoryFilm updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryFilm $categoryfilm)
    {
        $categoryfilm->delete();
        
        return back();
    }
}
