<?php

use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoGameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/games', [VideoGameController::class, 'index'])->name('games.index');
Route::get('/games/{videoGame}', [VideoGameController::class, 'show'])->name('games.show');
Route::post('/games', [VideoGameController::class, 'store'])->name('games.store')->withoutMiddleware([VerifyCsrfToken::class]);
Route::delete('/games/{videoGame}', [VideoGameController::class, 'destroy'])->name('games.destroy')->withoutMiddleware([VerifyCsrfToken::class]);
Route::put('/games/{videoGame}', [VideoGameController::class, 'update'])->name('games.update')->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms.index');

require __DIR__.'/auth.php';
