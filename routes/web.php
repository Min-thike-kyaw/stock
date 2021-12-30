<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function(){
    Route::prefix('stocks')->group(function(){
        Route::get('/','StockController@index')->name('stock.index');
        Route::post('/store','StockController@store')->name('stock.store');
        Route::put('{stock}/update','StockController@update')->name('stock.update');
        Route::delete('{stock}/delete','StockController@destroy')->name('stock.destroy');
    });

    Route::prefix('units')->group(function(){
        Route::get('/','UnitController@index')->name('unit.index');
        Route::post('/store','UnitController@store')->name('unit.store');
        Route::put('/{unit}/update','UnitController@update')->name('unit.update');
        Route::delete('{unit}/delete','UnitController@destroy')->name('unit.destroy');
    });
    Route::prefix('detail')->group(function(){
        Route::put('{detail}/update','StockDetailController@update')->name('detail.update');
        Route::delete('{detail}/delete','StockDetailController@destroy')->name('detail.destroy');
    });
    Route::prefix('stock_histories')->group(function(){
        Route::get('/','StockHistoryController@index')->name('history.index');
        Route::post('/{stock_history}/store','StockHistoryController@store')->name('history.store');
        Route::get('/{stock_history}/details' ,'StockHistoryController@detail')->name('history.detail');
        Route::delete('{stock_history}/delete','StockHistoryController@destroy')->name('history.destroy');
    });
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
