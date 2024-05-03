<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLikeReviewRequest;
use App\Http\Resources\UserLikeReviewResource;
use App\Models\Likes;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLikeReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $likesCount = Likes::where('review_id', $reviewId)->where('like', 1)->count();

        // return response()->json(['likesCount' => $likesCount]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserLikeReviewRequest $request)
    {
        $currentUser = auth()->user();
        $reviewId = $request->review_id;

        $this->validate($request, [
            'review_id' => 'required|integer|exists:reviews,id',
            'like' => 'required|boolean',
        ]);

        // Получаем отзыв по его id
        $review = Review::findOrFail($reviewId);

        // Проверяем, принадлежит ли отзыв текущему пользователю
        if ($request->like && $review->user_id === $currentUser->id) {
            return response()->json(['error' => 'Нельзя лайкнуть свой отзыв'], 400);
        }

        $existingLike = Likes::where('user_id', $currentUser->id)
            ->where('review_id', $reviewId)
            ->first();

        if ($existingLike) {
            if ($existingLike->like !== $request->like) {
                $existingLike->like = $request->like;
                $existingLike->save();
            }

            return response()->json(['message' => 'Лайк обновлен'], 200);
        }

        $like = Likes::create([
            'user_id' => $currentUser->id,
            'review_id' => $reviewId,
            'like' => $request->like,
        ]);

        return response(new UserLikeReviewResource($like), 201);
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
    public function destroy(string $id)
    {
        //
    }
}