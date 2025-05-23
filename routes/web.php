<?php

use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoGameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/users/verify', [UserController::class, 'show'])->name('users.verify')->withoutMiddleware([VerifyCsrfToken::class]);
// Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/games', [VideoGameController::class, 'index'])->name('games.index');

Route::get('/user/games', [VideoGameController::class, 'getUserGames'])->name('games.getUserGames')->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/games/{videoGame}', [VideoGameController::class, 'show'])->name('games.show');

Route::post('/games', [VideoGameController::class, 'store'])->name('games.store')->withoutMiddleware([VerifyCsrfToken::class]);
Route::delete('/games/{videoGame}', [VideoGameController::class, 'destroy'])->name('games.destroy')->withoutMiddleware([VerifyCsrfToken::class]);
Route::put('/games/{videoGame}', [VideoGameController::class, 'update'])->name('games.update')->withoutMiddleware([VerifyCsrfToken::class]);


Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms.index');

require __DIR__.'/auth.php';
