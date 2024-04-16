<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GenderResource;
use App\Models\Gender;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 30);
        $sortBy = $request->query('sortBy', 'name');
        $sortDir = $request->query('sortDir', 'asc');        

        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        $genders = Gender::query();
        
        if ($request->has('search')) {
            $genders = $genders->where('name', 'like', '%' . $request->query('search') . '%');
        }

        if ($sortBy === 'name') {
            $genders = $genders->orderBy($sortBy, $sortDir);
        }

        $genders = $genders->paginate($size);
        
        return response([
            'genders' => GenderResource::collection($genders),
        ]);
    }

}
