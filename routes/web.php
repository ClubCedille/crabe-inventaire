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


    Auth::routes(['verify' => true]);

    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['middleware' => 'verified'], function () {

            // route for processing payment
            Route::post('payaccount', 'TransactionController@payAccountActivation');

            Route::group(['middleware' => 'onlynot.active'], function () {
                //payment to activate account
                Route::get('activer', 'TransactionController@index')->name('activer');
                // route for check status of the payment for account activation
                Route::get('statusactivation', 'TransactionController@getPaymentStatusActivation')->name('statusactivation');
            });

            Route::group(['middleware' => 'valid.membership'], function () {

                Route::resource('products','ProductsController')->only(['index','show']);
                Route::get('home', 'HomeController@index')->name('home');
                Route::get('category', 'CategoryController@index');
                //payment for normal product transaction
                Route::post('transaction', 'TransactionController@transactionPayement');
                // route for check status of the payment of a transaction
                Route::get('statustransaction', 'TransactionController@getTransactionStatus')->name('statustransaction');

                Route::group(['middleware' => 'admin'], function () {
                Route::resource('products','ProductsController')->only([
                        'create',
                        'store',
                        'edit',
                        'update',
                        'destroy']);
                Route::get('category/{id}', 'CategoryController@show');
                Route::post('category', 'CategoryController@store');
                Route::put('category/{id}/edit', 'CategoryController@edit');
                Route::get('category/{id}', 'CategoryController@update');
                Route::delete('category/{id}', 'CategoryController@delete');

                });

            });
        });

        
    });
});
