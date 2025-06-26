<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    public function book(){
        return $this->belongsTo(Book::class);
    }

    protected $guarded = [];
}
