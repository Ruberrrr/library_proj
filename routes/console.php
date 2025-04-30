<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Reservation;
use Carbon\Carbon;

Schedule::call(function () {
    $expiredReservations = Reservation::where('expires_at', '<', Carbon::now())->get();

    foreach ($expiredReservations as $reservation) {
        $book = $reservation->book;

        if ($book) {
            $book->is_reserved = false;
            $book->reserved_by = null;
            $book->save();
        }
        $reservation->delete();
    }

    Log::info('Просроченные брони успешно удалены.');
})->daily();