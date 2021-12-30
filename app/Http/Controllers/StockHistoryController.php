<?php

namespace App\Http\Controllers;

use App\StockDetail;
use App\Unit;
use Carbon\Carbon;
use App\StockHistory;
use Illuminate\Http\Request;

class StockHistoryController extends Controller
{
    public function index()
    {
        // dd("3");
        return view('stock-history.index',[
            "stock_histories" => StockHistory::all()
        ]);
    }

    public function detail(StockHistory $stock_history)
    {
        // dd($stock_history);
        return view('stock-history.detail',["stock_history" => $stock_history]);
    }

    public function store(Request $request, $stock_id)
    {

        $history = new StockHistory();
        $history->stock_id = $stock_id;
        $history->date = Carbon::now();
        $history->save();
        // StockDetail::created($request->all(), $history->id);
        foreach($request->all() as $key=>$value){

            if($key != "_token"&& $value != 0){
                $request->validate([
                    $value => "integer"
                ]);
                // dd(Unit::where("name",$key)->first()->id);
                $unit_id = Unit::where("name" , $key)->first()->id;
                $qty = $value;
                $stock_detail = new StockDetail();
                $stock_detail->stock_history_id = $history->id;
                $stock_detail->unit_id = $unit_id;
                $stock_detail->qty = $qty;
                $stock_detail->save();
            }
        };
        return redirect()->back();
    }

    public function destroy($id)
    {
        $stock_history = StockHistory::find($id);
        foreach (StockDetail::where('id',$id)->get() as $detail) {
            $detail->delete();
        }
        $stock_history->delete();

        return redirect()->back();
    }
}
