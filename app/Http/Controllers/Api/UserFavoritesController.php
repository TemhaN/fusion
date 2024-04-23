<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserFavoriteRequest;
use App\Http\Resources\UserFavoriteResource;
use App\Models\Favorites;
use App\Models\User;
use Illuminate\Http\Request;

class UserFavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response(['message' => 'User not found'], 404);
        }

        $favorites = $user->favorites();

        return response(['favorites' => UserFavoriteResource::collection($favorites->get())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFavoriteRequest $request)
    {
        $data = $request->validated();

        $existingFavorites = Favorites::where('user_id', $data['user_id'])
        ->where('film_id', $data['film_id'])
        ->first();

        if ($existingFavorites) {
            return response()->json(['error' => 'Favorite already exists for this user and movie'], 409);
        }

        $favorite = Favorites::create($data);

        return response(new UserFavoriteResource($favorite), 201);
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
    public function destroy($userId, $favoritesId)
    {
        $user = User::findOrFail($userId);
        $favorites = $user->favorites()->findOrFail($favoritesId);

        if ($favorites->user_id != auth()->user()->id) {
            return response(['error' => 'You can only delete your own favorites'], 403);
        }

        $favorites->delete();

        return response('', 204);
    }
}
