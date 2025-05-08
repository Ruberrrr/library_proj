<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reservation;


class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = ['title', 'author', 'reserved_by', 'expires_at', 'give'];
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function reservedUser()
    {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    
    public function reservation()
    {
        return $this->hasOne(Reservation::class)->latestOfMany();
    }

    
    public function librarian()
    {
        return $this->reservation ? $this->reservation->librarian : null;
    }
}