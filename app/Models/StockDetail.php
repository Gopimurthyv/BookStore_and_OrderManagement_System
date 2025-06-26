<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDetail extends Model
{

    public function getTotalStockAttribute(){
        return $this->stock->sum('quantity');
    }

    protected $guarded = [];
}
