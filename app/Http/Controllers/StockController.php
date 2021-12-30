<?php

namespace App\Http\Controllers;

use App\Stock;
use App\StockHistory;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock.index',['stocks'=> Stock::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "name" => "required",
            // "user_id" => "required"
        ]);

        // dd($request->all());
        $stock = Stock::create($request->all());
        $stock->units()->attach($request->unit_id);
        return redirect()->back();
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            "name" => "required",
            "unit_id" => "required"
        ]);
        $stock->units()->detach();
        $stock->name = $request->name;
        $stock->save();
        $stock->units()->attach($request->unit_id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        $stock->units()->detach();
        foreach (StockHistory::where('id',$stock->id)->get() as $history) {
            $history->delete();
        }
        $stock->delete();
        return redirect()->back();
    }
}
