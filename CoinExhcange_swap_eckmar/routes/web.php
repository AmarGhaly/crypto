<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('app.route_prefix'))->group(function(){
    Route::get('login','AuthController@signInShow')->name('auth.login');
    Route::post('login','AuthController@signInPost')->name('auth.login.post');

    Route::middleware(['auth'])->prefix('admin')->group(function (){
        Route::get('index/{param?}/{query?}','AdminController@index')->name('admin.index');
        Route::get('trade/{trade}','AdminController@trade')->name('admin.trade');
        Route::post('trade/{trade}','AdminController@updateTrade')->name('admin.trade.update');

        Route::post('trade/filter/params','AdminController@filter')->name('admin.trade.filter');

        Route::get('users','AdminController@users')->name('admin.users');
    });
    Route::post('signout','AuthController@signOut')->name('auth.logout');
});


Route::post('confirm','TradeController@confirmPost')->name('trade.confirm.post');
Route::get('confirm','TradeController@confirmShow')->name('trade.confirm.show');
Route::post('create','TradeController@create')->name('trade.create');
Route::get('trade/{trade}','TradeController@showTrade')->name('trade');


Route::get('/{direction?}','HomeController@index')->name('home');

//Route::get('/cryptiswap', "TradeSwap@makeOrder");
