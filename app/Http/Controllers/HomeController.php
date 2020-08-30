<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

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
        if (Auth::check())
        {
            $user = Auth::user();
        }
        $cart = $user->cart;
        $products = Product::whereNotIn('id', [1, 2])->get();
        $productsAll = Product::all();
        return view('home', compact('user','products','cart','productsAll'));
    }
}
