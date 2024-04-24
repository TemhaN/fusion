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
    public function index($reviewId)
    {
        $likesCount = Likes::where('review_id', $reviewId)->where('like', 1)->count();

        return response()->json(['likesCount' => $likesCount]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserLikeReviewRequest $request, $userId, Review $reviewId)
    {
        $currentUser = auth()->user();

        if ($reviewId->user_id === $currentUser->id) {
            return response()->json(['error' => 'Нельзя лайкнуть свой отзыв'], 400);
        }

        $existingLike = Likes::where('user_id', $currentUser->id)
            ->where('review_id', $reviewId->id)
            ->first();

        if ($existingLike) {
            return response()->json(['error' => 'Вы уже лайкнули/дизлайкнули этот отзыв'], 400);
        }

        $like = $request->input('like') === 1 ? 1 : 0;
        $userLikeReview = Likes::create([
            'user_id' => $currentUser->id,
            'review_id' => $reviewId->id,
            'like' => $like,
        ]);

        return response (new UserLikeReviewResource($userLikeReview));
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
