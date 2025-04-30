<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;

// Route::middleware(['admin'])->group(function () {
//     Route::put('users/password', [PasswordController::class, 'update'])->name('password.update');
//     Route::post('users', [UserController::class, 'store'])->name('user.add');
//     Route::delete('users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
// });