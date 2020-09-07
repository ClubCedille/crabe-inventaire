<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\AppTransaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
        }

        if ($user->isAdmin) {
            $products = Product::where('quantity', '<', 5)->orderBy('quantity', 'asc')
                    ->get();

            return view('home', compact('products'));
        } else {
            $cart = $user->cart;
            $products = Product::whereNotIn('id', [1, 2])->get();
            $productsAll = Product::all();
            return view('home', compact('user', 'products', 'cart', 'productsAll'));
        }
    }



    /**
     * download the products report
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function downloadProductsReport()
    {
        $products = Product::all();
        $currentDate = date('Y-m-d');
    
        $pdf = \PDF::loadView('report.products', compact('products', 'currentDate'));

        return $pdf->download('products_report.pdf');
    }


    /**
    * download the transactions report
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function downloadTransactionsReport($start, $end)
    {
        $start_converted = strtotime($start);
        $end_converted= strtotime($end);
        
        if ($start_converted !== false && $end_converted !== false) {
            $start_converted = date('Y-m-d', $start_converted);
            $end_converted = date('Y-m-d', $end_converted);

            $transactions = AppTransaction::whereBetween('created_at', [$start_converted, $end_converted])->with('user')->get();
            $currentDate = date('Y-m-d');
            $pdf = \PDF::loadView('report.transactions', compact('transactions', 'currentDate'));

            return $pdf->download('transactions_report.pdf');
        }
    }
}
