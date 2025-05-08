<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'librarian_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }
    

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}