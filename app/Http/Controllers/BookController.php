<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reservation;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['reservedUser', 'reservation.librarian']);
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sortBy') && $request->sortBy === 'alphabet') {
            $query->orderBy('title', 'asc');
        }

        if ($request->has('sortBy') && $request->sortBy === 'author') {
            $query->orderBy('author', 'asc');
        }

        if ($request->context === 'books') {
            $query->orderBy('id', 'asc');
        } else {
            $query->orderByDesc('is_reserved');
            $query->orderBy('id', 'asc');
        }
        
        $books = $query->get(); 
        
        return response()->json($books);
    }
    
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
        ]);
        $book = Book::create($validatedData);

        return response()->json($book, 201);
        
    }


    public function toggleGive($id)
    {
        $book = Book::findOrFail($id);
        $librarian = Auth::user();
        $reservation = Reservation::where('book_id', $book->id)->latest()->first();

        if ($book->give) {
            $book->give = false;
            $book->reserved_by = null;
            $book->is_reserved = false;
            $book->save();
    
            if ($reservation) {
                $reservation->librarian_id = null;
                $reservation->issued_at = null;
                $reservation->save();
            }
        } else {
            $book->give = true;
            $book->save();
    
            if ($reservation) {
                $reservation->librarian_id = $librarian->id;
                $reservation->issued_at = Carbon::now();
                $reservation->save();
            }
        }

        return response()->json([
            'give' => $book->give,
        ]);
    }
    

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(null, 204);
    }
}