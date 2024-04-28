<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 100);
        $sortBy = $request->query('sortBy', 'name');
        $sortDir = $request->query('sortDir', 'asc');

        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        $categories = Category::query();

        if ($request->has('search')) {
            $search = '%' . $request->query('search') . '%';
            $categories = $categories->where(function ($query) use ($search) {
                $query->where('name', 'like', $search)
                    ->orWhereHas('parent', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    });
            });
        }
        if ($sortBy === 'name') {
            $categories = $categories->orderBy($sortBy, $sortDir);
        }

        elseif ($sortBy === 'filmCount') {
            $categories = $categories
            ->withCount('films')
            ->orderBy('films_count', $sortDir);
        }

        $categories = $categories->paginate($size);

        return response([
            'categories' => CategoryResource::collection($categories),
        ]);
    }
}
