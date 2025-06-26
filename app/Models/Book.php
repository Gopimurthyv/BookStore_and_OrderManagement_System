<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    public function authors(){
        return $this->hasMany(BookAuthor::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function stocks(){
        return $this->hasMany(StockDetail::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function order(){
        return $this->belongsToMany(Order::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    protected $guarded = [];

    public $casts = ['category','array'];
}
