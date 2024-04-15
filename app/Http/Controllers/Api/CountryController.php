<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
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

        $countries = Country::query();
        
        if ($request->has('search')) {
            $countries = $countries->where('name', 'like', '%' . $request->query('search') . '%');
        }

        if ($sortBy === 'name') {
            $countries = $countries->orderBy($sortBy, $sortDir);
        }

        elseif ($sortBy === 'filmCount') {
            $countries = $countries
            ->withCount('films')
            ->orderBy('films_count', $sortDir);
        }

        $countries = $countries->paginate($size);
        
        return response([
            'countries' => CountryResource::collection($countries),
        ]);
    }
}
