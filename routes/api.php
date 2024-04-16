<?php

use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\ReviewController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::patch('users/{user}', [UserController::class, 'update'])->name('admins.users.update');
