<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::get('/book', [BookController::class, 'index'])->name('book.all');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/book/{bookId}/reserve', [ReservationController::class, 'reserveBook']);
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::put('users/{id}/password', [UserController::class, 'update'])->name('password.update');
    Route::post('/users', [UserController::class, 'store'])->name('user.add');
    Route::get('users', [UserController::class, 'index'])->name('user.all');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('login',[UserController::class, 'index']);
});
Route::middleware(['auth:sanctum','role:librarian'])->group(function () {
    Route::delete('/book/{id}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::patch('/book/{id}/toggle-give', [BookController::class, 'toggleGive']);
    Route::post('books/create', [BookController::class, 'store'])->name('book.add');

});