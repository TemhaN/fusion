<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserReviewsRequest;
use App\Http\Resources\UserReviewsResource;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class UserReviewsController extends Controller
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
        $reviews = $user->reviews();

        if (auth()->user()->id != $id) {
            $reviews->where('is_approved', 1);
        }
        return response(['reviews' => UserReviewsResource::collection($reviews->get())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserReviewsRequest $request)
    {
        $data = $request->validated();

        $review = Review::create($data);
        $review->is_approved = 0;

        return response(new UserReviewsResource($review), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $reviewId)
    {
        $user = User::findOrFail($userId);
        $review = $user->reviews()->findOrFail($reviewId);

        if ($review->user_id != auth()->user()->id) {
            return response(['error' => 'You can only delete your own reviews'], 403);
        }

        $review->delete();

        return response(['status' => 'success'], 200);
    }

}
