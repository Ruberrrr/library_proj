<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function reserveBook(Request $request, $bookId)
    {
        $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Неавторизованный пользователь'], 403);
    }

    $book = Book::findOrFail($bookId);

    if ($book->is_reserved) {
        return response()->json(['message' => 'Книга уже зарезервирована'], 400);
    }

    $existingReservation = Reservation::where('book_id', $book->id)
        ->where('user_id', $user->id)
        ->first();

    if ($existingReservation) {
        return response()->json(['message' => 'Вы уже зарезервировали эту книгу'], 400);
    }

    $reservation = new Reservation();
    $reservation->user_id = $user->id;
    $reservation->book_id = $book->id;

    $reservation->expires_at = Carbon::now()->addWeek();
    
    $reservation->save();
    
    $book->is_reserved = true;
    $book->reserved_by = $user->id;
    $book->save();

    return response()->json(['message' => 'Книга успешно забронирована'], 200);
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