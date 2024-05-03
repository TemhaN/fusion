<?php

use App\Http\Controllers\Api\ActorsController;
use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserFavoritesController;
use App\Http\Controllers\Api\UserLikeReviewController;
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
Route::get('/film/{filmId}/favorites', [FilmController::class, 'favorites']);
Route::get('/film/{filmId}/actors', [FilmController::class, 'actors']);

Route::get('/topRatedFilmLink', [MainController::class, 'getTopRatedFilmLink']);
Route::get('/getTopRatedFilmList', [MainController::class, 'getTopRatedFilmList']);

// Route::get('/review/{reviewId}/likes', [UserReviewsController::class, 'index']);

Route::get('/categories', CategoryController::class);
Route::get('/countries', CountryController::class);
Route::get('/genders', GenderController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/signout', [AuthController::class, 'signout']);

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);

    Route::get('/user/{userId}/reviews', [UserReviewsController::class, 'index']);
    Route::delete('/user/{userId}/review/{reviewId}', [UserReviewsController::class, 'destroy']);

    Route::get('/user/{userId}/ratings', [UserRatingController::class, 'index']);
    Route::delete('/user/{userId}/rating/{ratingId}', [UserRatingController::class, 'destroy']);

    Route::get('/user/{userId}/favorites', [UserFavoritesController::class, 'index']);
    Route::delete('/user/{userId}/favorite/{filmId}', [UserFavoritesController::class, 'destroy']);


    Route::middleware(['check.id'])->group(function () {

        Route::post('/user/{userId}/reviews', [UserReviewsController::class, 'store']);

        Route::post('/user/{userId}/ratings', [UserRatingController::class, 'store']);

        Route::post('/user/{userId}/favorites', [UserFavoritesController::class, 'store']);

        Route::post('/user/{userId}/review', [UserLikeReviewController::class, 'store']);

    });
});



Route::patch('users/{user}', [UserController::class, 'update'])->name('admins.users.update');