<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reservations;


class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = ['title', 'author', 'reserved_by', 'give'];
    protected $visible = ['id', 'title', 'author', 'is_reserved', 'reserved_by', 'give'];
    public function reservations()
    {
    return $this->hasMany(Reservation::class);
    }   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}