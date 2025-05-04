<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        $query->orderByDesc('is_reserved');
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sortBy') && $request->sortBy === 'alpabet') {
            $query->orderBy('title', 'asc');
        }
        if ($request->has('sortBy') && $request->sortBy === 'author') {
            $query->orderBy('author', 'asc');
        }

        return response()->json($query->get());
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
    $book->give = !$book->give;
    $book->save();

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