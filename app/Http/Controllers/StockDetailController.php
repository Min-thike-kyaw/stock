<?php

namespace App\Http\Controllers;

use App\Unit;
use App\StockDetail;
use Illuminate\Http\Request;

class StockDetailController extends Controller
{
    public function update(Request $request, StockDetail $detail)
    {
        $request->validate([
            "qty" => "required"
        ]);
        $detail->qty = $request->qty;
        $detail->save();
        return redirect()->back();

    }
    public function destroy(StockDetail $detail)
    {
        $detail->delete();
        return redirect()->back();
    }
}
