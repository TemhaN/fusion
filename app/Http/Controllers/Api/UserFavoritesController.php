<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserFavoriteRequest;
use App\Http\Resources\UserFavoriteResource;
use App\Models\Favorites;
use App\Models\Film;
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
    public function store(Request $request, $userId)
    {

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $filmId = $request->input('film_id');
        if (!$filmId) {
            return response()->json(['error' => 'Film ID is required'], 400);
        }

        $filmExists = Film::where('id', $filmId)->exists();
        if (!$filmExists) {
            return response()->json(['error' => 'Film not found'], 404);
        }

        $existingFavorite = Favorites::where('user_id', $userId)
            ->where('film_id', $filmId)
            ->first();

        if ($existingFavorite) {
            return response()->json(['error' => 'Favorite already exists for this user and movie'], 409);
        }

        $favorite = Favorites::create([
            'user_id' => $userId,
            'film_id' => $filmId,
        ]);

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
    public function destroy(Request $request, $userId, $filmId)
    {
        // Проверяем, есть ли пользователь с указанным ID
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Проверяем, есть ли обязательный параметр film_id в запросе
        if (!$filmId) {
            return response()->json(['error' => 'Film ID is required'], 400);
        }

        // Находим запись избранного фильма для данного пользователя и film_id
        $favorites = Favorites::where('user_id', $userId)
            ->where('film_id', $filmId)
            ->first();

        if (!$favorites) {
            return response()->json(['error' => 'Favorite not found for this user and movie'], 404);
        }

        // Проверяем, может ли текущий пользователь удалить этот избранный фильм
        if ($favorites->user_id != auth()->user()->id) {
            return response()->json(['error' => 'You can only delete your own favorites'], 403);
        }

        // Удаляем запись из таблицы Favorites
        $favorites->delete();

        // Возвращаем успешный ответ
        return response('', 204);
    }
}