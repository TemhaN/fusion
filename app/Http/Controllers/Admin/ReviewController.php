<?php

namespace App\Http\Controllers\Admin;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Film;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        $films = Film::withCount('reviews')->get();

        // $film = Film::findOrFail($film_id);
        $ratings = Rating::all();

        return view('admins.reviews.index', compact('reviews', 'films', 'ratings'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function approved($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return redirect()->back()->with('success', 'Отзыв одобрен!');
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
    public function show($film_id)
    {
        $users = User::all();
        $reviews = Review::where('film_id', $film_id)->get();
        $film = Film::findOrFail($film_id);

        $averageRating = round(Rating::where('film_id', $film_id)->avg('ball'), 1);
        $ratings = Rating::where('film_id', $film_id)->with('user')->get();

        return view('admins.films.show', compact('reviews', 'film', 'users', 'ratings', 'averageRating')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function approve($id)
    {
        $review = Review::find($id);
        $review->is_approved = true;
        $review->save();

        return back();
    }
    public function toggle($id)
    {
        $review = Review::find($id);
        $review->is_approved = !$review->is_approved;
        $review->save();

        return back();
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
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Отзыв удален!');
    }

}
