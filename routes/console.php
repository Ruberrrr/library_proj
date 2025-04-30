<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Reservation;

Schedule::call(function () {
    $expiredReservations = Reservation::where('expires_at', '<', now())->get();

    foreach ($expiredReservations as $reservation) {
        $book = $reservation->book;
        if ($book) {
            $book->is_reserved = false;
            $book->save();
        }
        $reservation->delete();
    }

    \Log::info('Просроченные брони успешно удалены.');
})->daily();