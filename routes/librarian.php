<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReservationController;

Route::get('book', [BookController::class, 'index'])->name('book.all');
Route::post('book', [BookController::class, 'store'])->name('book.add');
Route::delete('book/{id}', [BookController::class, 'destroy'])->name('book.destroy');
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
