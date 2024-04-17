<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\CategoryFilm;
use App\Models\Country;
use App\Models\Film;
use App\Models\Rating;
use App\Models\User;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $filmsCount = Film::count();
        $categoriesCount = Category::count();
        $countriesCount = Country::count();

        $categoryFilmCounts = CategoryFilm::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $categoryNames = Category::whereIn('id', $categoryFilmCounts->pluck('category_id'))->pluck('name', 'id')->values()->all();

        $averageRatings = Rating::select('film_id', DB::raw('AVG(ball) as average_rating'))
            ->groupBy('film_id')
            ->get();

        $topRatedFilms = $averageRatings->sortByDesc('average_rating')->take(5);

        $filmNames = Film::whereIn('id', $topRatedFilms->pluck('film_id'))->pluck('name', 'id')->values()->all();

        $data = [
            'usersCount' => $usersCount,
            'filmsCount' => $filmsCount,
            'topRatedFilms' => $topRatedFilms,
            'filmNames' => $filmNames,
            'categoriesCount' => $categoriesCount,
            'countriesCount' => $countriesCount,
            'categoryFilmCounts' => $categoryFilmCounts,
            'categoryNames' => $categoryNames
        ];

        return view('index', $data);
    }
}

