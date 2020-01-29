<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Redirect;

class ProductsController extends Controller
{
    /**
     * Send all resource as JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::all();

        return response()->json($products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPage()
    {
        $this->authorize('viewAny', Product::class);

        $categories = Category::all();
        $products = Product::all();
        //return response()->json($products);
        return view('product/index')->with(['products' => $products,'categories' => $categories,'message' =>'']);

        //return view('product/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //dd('qqch random');
        $this->authorize('create', Product::class);
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $validData = $request->validate([
            'code' => 'alpha_num|required|between:5,30|unique:products,code',
            'name' => 'string|required|max:50',
            'description' => 'string|required|max:250',
            'price' => 'numeric|required|gt:0',
            'quantity' => 'numeric|required',
            'category_id' => 'numeric|required|exists:categories,id'
        ]);

        Product::create($validData);

        //return response()->json('Le produit a été créé avec succès.');
        return Redirect::to('/product');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        // Retourne une erreur quand Category n'est pas trouvé (JSON)
        if (!$product) return parent::notFoundResponse();

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $product = Product::find($code);
        $categories = Category::all();
        // return response()->json($product);
        return view('product.update')->with(['product' => $product,'categories' => $categories,'message' =>'']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $this->authorize('update', $product);

        $validData = $request->validate([
            'code' => 'string|required|between:5,30',
            'name' => 'string|required|max:50',
            'description' => 'string|required|max:250',
            'price' => 'numeric|required|gt:0',
            'quantity' => 'numeric|required',
            'category_id' => 'numeric|required|exists:categories,id',
        ]);

        if (!$product) abort(Response::HTTP_NOT_FOUND);

        $product->code = $validData["code"];
        $product->name = $validData["name"];
        $product->description = $validData["description"];
        $product->price = $validData["price"];
        $product->quantity = $validData["quantity"];
        $product->category_id = $validData["category_id"];

        $product->update();

        //return response()->json("Le produit a été mis à jour.");
        return Redirect::to('/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        $product = Product::where('code', $code);
        if (!$product) abort(Response::HTTP_NOT_FOUND);
        $product->delete();
        return response()->json("Le produit fut supprimé.");

    }
}
