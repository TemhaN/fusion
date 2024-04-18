<?php

use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserRatingController;
use App\Http\Controllers\Api\UserReviewsController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/films', [FilmController::class, 'index']);
Route::get('/film/{id}', [FilmController::class, 'show']);
Route::get('/film/{filmId}/reviews', [FilmController::class, 'reviews']);

Route::get('/categories', CategoryController::class);
Route::get('/countries', CountryController::class);
Route::get('/genders', GenderController::class);


// Route::get('/categories', [CategoryController::class, 'index']);
// Route::get('/reviews', [ReviewController::class, 'index']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/signout', [AuthController::class, 'signout']);

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);

    Route::get('/user/{userId}/reviews', [UserReviewsController::class, 'index']);
    Route::delete('/user/{userId}/reviews/{reviewId}', [UserReviewsController::class, 'destroy']);

    Route::get('/user/{userId}/ratings', [UserRatingController::class, 'index']);
    Route::delete('/user/{userId}/rating/{ratingId}', [UserRatingController::class, 'destroy']);

    Route::middleware(['check.id'])->group(function () {
        Route::post('/user/{userId}/reviews', [UserReviewsController::class, 'store']);
        Route::post('/user/{userId}/rating', [UserRatingController::class, 'store']);
    });
});



Route::patch('users/{user}', [UserController::class, 'update'])->name('admins.users.update');
