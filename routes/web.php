<?php

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



Route::group(['middleware' => 'web'], function () {

    Auth::routes();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['middleware' => 'auth'], function () {

        //**PAYPAL TRANSACTIONS  */
        //payment form
        Route::get('/reactiver-compte', 'TransactionController@index')->name('reactiver-compte');;
        // route for processing payment
        Route::post('transaction', 'TransactionController@payWithpaypal');
        // route for check status of the payment
        Route::get('status', 'TransactionController@getPaymentStatus');
       
        Route::get('home', 'HomeController@index')->name('home');
    
    });
});


