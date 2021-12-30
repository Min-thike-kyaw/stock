<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockHistory extends Model
{
    use SoftDeletes;

    protected $fillable = ["stock", "date"];
    public function stockDetails()
    {
        return $this->hasMany('App\StockDetail');
    }
    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
