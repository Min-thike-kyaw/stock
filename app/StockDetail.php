<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockDetail extends Model
{
    use SoftDeletes;

    protected $fillable = ["stock_history_id", "unit_id", "qty"];
    public function stockHistory()
    {
        return $this->belongsTo('App\StockHistory');
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
