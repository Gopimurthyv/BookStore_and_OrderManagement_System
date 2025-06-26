<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function books(){
        return $this->belongsToMany(Book::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    protected $guarded = [];
}
