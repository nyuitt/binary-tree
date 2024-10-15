<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CalculatePointsMiddleware; 
//use App\Http\Controllers\UserController;

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

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class,'index'])->name('user.index');
    Route::match(['get', 'post'], '/users/create', [UserController::class, 'create'])->name("user.create");
    Route::match(['get', 'post'], '/users/edit/{id}', [UserController::class, 'update'])->name("user.edit");
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::post('/recalculate-points', [UserController::class, 'calculatePoints'])->middleware(['auth', 'verified'])->name('recalculate.points');

require __DIR__.'/auth.php';
