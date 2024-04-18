<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserRatingResource;
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
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
