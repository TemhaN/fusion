<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\CategoryFilmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RatingFilmController;
use App\Http\Controllers\Admin\Easter_EggController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;

Route::middleware(['guest:admin'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login_process');
});

Route::middleware(['auth:admin'])->group(function()
{
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/', [AuthController::class, 'updateAdmin'])->name('admin.update');

    Route::resource('/countries', CountryController::class)->except(['show']);
    Route::resource('/categories', CategoryController::class)->except(['show']);
    Route::resource('/films', FilmController::class)->except(['show']);
    Route::resource('categoryfilms', CategoryFilmController::class);
    Route::resource('/reviews', ReviewController::class);
    Route::resource('/ratings', RatingFilmController::class);
    Route::resource('/easter_egg', Easter_EggController::class);


    Route::patch('/categoryfilm/{id}', [CategoryFilmController::class, 'update'])->name('categoryfilm.update');

    Route::get('/filminfo/{film_id}', [ReviewController::class, 'show'])->name('filminfo.show');
    Route::get('/filminfo', [ReviewController::class, 'show'])->name('admins.films.show');

    Route::patch('filminfo/{film_id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('filminfo/{film_id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::patch('filminfo/{film_id}/toggle', [ReviewController::class, 'toggle'])->name('reviews.toggle');
    
    Route::resource('/users', UserController::class)->except(['destroy']);
    Route::resource('/users', UserController::class)->except(['show']);
    Route::get('/admins/users', [UserController::class, 'index'])->name('admins.users.index');
    Route::delete('users/{user}/ban', [UserController::class, 'adminban'])->name('admins.users.ban');
    Route::put('users/{user}/restore', [UserController::class, 'adminrestore'])->name('admins.users.restore');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('admins.users.update');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

});