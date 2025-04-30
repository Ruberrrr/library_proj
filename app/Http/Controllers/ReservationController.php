<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request, $id)
    {

        $book = Book::findOrFail($id);

        if ($book->is_reserved) {
            return back()->with('error', 'Книга уже забронирована');
        }

        $user = Auth::user();

        $Reservations = new Reservation();
        $Reservations->user_id = $user->id;
        $Reservations->book_id = $book->id;
        $Reservations->expires_at = now()->addDays(7);
        $Reservations->save();

        $book->is_reserved = true;
        $book->save();

        return back()->with('success', 'Книга успешно забронирована');
    }

    public function destroy($id)
    {
        $Reservations = Reservation::findOrFail($id);
        $Reservations->delete();

        $book = $Reservations->book;
        $book->is_reserved = false;
        $book->save();

        return redirect()->back()->with('success', 'Бронирование удалено.');
    }
}