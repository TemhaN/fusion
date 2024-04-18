<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRatingRequest;
use App\Http\Resources\UserRatingResource;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class UserRatingController extends Controller
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
        $ratings = $user->ratings();

        return response(['ratings' => UserRatingResource::collection($ratings->get())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRatingRequest $request)
    {
        $data = $request->validated();

        $existingRating = Rating::where('user_id', $data['user_id'])
        ->where('film_id', $data['film_id'])
        ->first();

        if ($existingRating) {
            return response()->json(['error' => 'Rating already exists for this user and movie'], 409);
        }

        $rating = Rating::create($data);
        
        return response(new UserRatingResource($rating), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $ratingId)
    {
        $user = User::findOrFail($userId);
        $rating = $user->ratings()->findOrFail($ratingId);

        if ($rating->user_id != auth()->user()->id) {
            return response(['error' => 'You can only delete your own ratings'], 403);
        }

        $rating->delete();

        return response('', 204);
    }

}
