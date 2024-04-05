<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingFilmController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();
        return view('admins.ratings.index', compact('ratings'));
    }

    // Вывод оценок только выбранного фильма
    public function show($film_id)
    {
        $averageRating = Rating::where('film_id', $film_id)->avg('ball');
        $ratings = Rating::where('film_id', $film_id)->get();
        return view('ratings.show', compact('ratings', 'averageRating'));
    }

    // Удаление оценки фильма
    public function destroy($id)
    {
        $rating = Rating::find($id);
        $rating->delete();

        return redirect()->route('ratings.index')->with('success', 'Оценка удалена успешно');
    }
}
