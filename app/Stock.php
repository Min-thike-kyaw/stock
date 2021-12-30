<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];

    public function units()
    {
        return $this->belongsToMany('App\Unit');
    }

    public function stockHistories()
    {
        return $this->hasMany('App\StockHistory');
    }


}
