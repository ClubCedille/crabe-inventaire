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

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');


Route::group(['middleware' => 'web'], function () {


    Auth::routes(['verify' => true]);

    

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['middleware' => 'verified'], function () {

            // route for processing payment
            Route::post('payaccount', 'TransactionController@createOrderAccountActivation');

            Route::group(['middleware' => 'onlynot.active'], function () {
                //payment to activate account
                Route::get('activer', 'TransactionController@index')->name('activer');
                // route for check status of the payment for account activation
                Route::get('statusactivation', 'TransactionController@captureOrder')->name('statusactivation');
            });

            Route::group(['middleware' => 'valid.membership'], function () {

                //Cart
                Route::get('cart', 'CartController@index')->name('cart');
                Route::post('cart/{id}', 'CartController@update')->name('cartupdate');
                Route::delete('cart/{id}/{productId}', 'CartController@destroy')->name('removefromcarte');
                Route::delete('cart/{id}/product/{productId}', 'CartController@remove');

                //receipts
                Route::get('receipts', 'ReceiptsController@index')->name('receipts');
                Route::get('receipts/pdf/{id}', 'ReceiptsController@download')->name('receipt.pdf');

                //Route::resource('products','ProductsController')->only(['index','show']);
                Route::get('/', 'HomeController@index')->name('home'); 
                Route::get('product/index', 'ProductsController@index');
                Route::get('product', 'ProductsController@indexPage')->name('product');
                Route::get('product/{id}', 'ProductsController@show');


                Route::get('home', 'HomeController@index')->name('home');
                Route::get('category/index', 'CategoryController@index');
                
                //payment for normal product transaction
                Route::post('transaction', 'TransactionController@transactionPayement')->name('transaction');
                // route for check status of the payment of a transaction
                Route::get('statustransaction', 'TransactionController@getTransactionStatus')->name('statustransaction');

                Route::group(['middleware' => 'admin'], function () {
                    Route::get('category/{id}', 'CategoryController@show');
                    Route::post('category', 'CategoryController@store');
                    Route::get('category', 'CategoryController@indexPage')->name('category');
                    Route::get('category/{id}/edit', 'CategoryController@edit');
                    Route::post('category/{id}', 'CategoryController@update');
                    Route::delete('category/{id}', 'CategoryController@destroy');
                    // Route::get('newProduct', 'ProductsController@create');
                    Route::post('product', 'ProductsController@store');
                    Route::get('product/{code}/edit', 'ProductsController@edit');
                    Route::post('product/{id}', 'ProductsController@update');
                    Route::delete('product/{product}', 'ProductsController@destroy');
                });
            });
        });
    });
});
