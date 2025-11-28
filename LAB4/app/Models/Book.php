<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publish_date',
        'isbn',
        'genre',
        'borrow_by',
        'borrow_date',
        'return_date',
    ];
}
