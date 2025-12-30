<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', LogoutController::class)->name('logout');

Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.reset.update');

Route::middleware('auth')->group(function (): void {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/recipes/{recipe}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])->name('reviews.report');
    Route::patch('/reviews/{review}/moderate', [ReviewController::class, 'moderate'])->name('reviews.moderate');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tags', AdminTagController::class)->except(['show']);
});

Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');
