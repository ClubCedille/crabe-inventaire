<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::all();
        return response()->json($products);
        //return View::make('products/index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        //return view('products.create');
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

        $validData = request()->validate([
            'code' => 'alpha_num|required|between:5,30|unique:products,code',
            'name' => 'string|required|max:50',
            'description' => 'string|required|max:250',
            'price' => 'numeric|required|gt:0',
            'category_id' => 'numeric|required|exists:categories,id'
        ]);

        Product::create($validData);

        return response()->json('Le produit a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return response()->json($product);
        // return View::make('products/show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

       // return view('products.edit', compact('product'));
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
            'code' => 'alpha_num|required|between:5,30',
            'name' => 'string|required|max:50',
            'description' => 'string|required|max:250',
            'price' => 'numeric|required|gt:0',
            'category_id' => 'numeric|required|exists:categories,id',
        ]);

        $product->code = $validData["code"];
        $product->name = $validData["name"];
        $product->description = $validData["description"];
        $product->price = $validData["price"];
        $product->category_id = $validData["category_id"];

        $product->update();

        return response()->json("Le produit a été mis à jour.");
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete',$product);

        $product->delete();
        return response()->json("Le produit fut supprimé.");
    }
}
