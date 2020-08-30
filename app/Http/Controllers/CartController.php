<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Cart;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::check())
        {
            $user = Auth::user();
            $cart = $user->cart;
        }

        /**
         * process products array to olny have
         * one key per products and add count of porduct in
         * the cart
         */
        list($products,$uniqueIds) = $this->filterProductsArray($cart->products);

        foreach($products as $product){
            $product["count"] = $uniqueIds[$product->id];
        }

        return view('cart/cart', compact('products','cart'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        if (Auth::check())
        {
            $user = Auth::user();
            $cart = $user->cart;
        }

        /**
         * process products array to olny have
         * one key per products and add count of porduct in
         * the cart
         */
        list($products,$uniqueIds) = $this->filterProductsArray($cart->products);

        foreach($products as $product){
            $product["count"] = $uniqueIds[$product->id];
        }

        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = [];
        $cart = Cart::find($id);
        $cart->products()->attach($request->productId);
        $cart->save();
        
        list($products,$uniqueIds) = $this->filterProductsArray($cart->products);

        foreach($products as $product){
            if($product["id"] == $request->productId){
                $product["count"] = $uniqueIds[$product->id];
                $result = $product;
            }
        }

        return response()->json($result);
    }

    /**
     * Remove al product by unique id from cart
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $productId)
    {
        
        $cart = Cart::find($id);

        
        /**
         * recuperer les ids de chaque product dans le cart
         * et retirer selon l'id donne en param
         */
        $indexToRemove = [];
        $i  = 0;
        
        $productIds = $this->getOnlyIds($cart->products);

        foreach($productIds as $key){
            
            if($key == $productId){
                array_push($indexToRemove , $i);
            }
            $i  = $i +1;
        }

        foreach($indexToRemove as $key){
            unset($productIds[$key]);
        }
      
        /**
         * mettre a jour le cart dans la base de donnees
         */
        $cart->products()->detach();
        $cart->products()->attach($productIds);
        $cart->save();

         /**
         * compter le nombre de produits qui ont pareils dans le cart
         * et ajouter ce chiffre au produit retourne
         */
        $cartNew = Cart::find($id);
        list($products,$uniqueIds) = $this->filterProductsArray($cartNew->products);
      
        $result = [];
        foreach($products as $product){
            $product["count"] = $uniqueIds[$product->id];
            array_push($result ,$product);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function remove($id, $productId)
    {
        $tmpId = 0;
        $i  = 0;
        $cart = Cart::find($id);

        /**
         * recuperer les ids de chaque product dans le cart
         * et retirer selon l'id donne en param
         */
        $productIds = $this->getOnlyIds($cart->products);
     
        foreach($productIds as $key){
            
            if($key == $productId){
                $tmpId = $i;
                break;
            }
            $i  = $i +1;
        }
        
        array_splice($productIds, $tmpId, 1);

        /**
         * mettre a jour le cart dans la base de donnees
         */
        $cart->products()->detach();
        $cart->products()->attach($productIds);
        $cart->save();
       

         /**
         * compter le nombre de produits qui ont pareils dans le cart
         * et ajouter ce chiffre au produit retourne
         */
        $cartNew = Cart::find($id);
        list($products,$uniqueIds) = $this->filterProductsArray($cartNew->products);

        $result = [];
        foreach($products as $product){
            if($product->id == $productId){
                $product["count"] = $uniqueIds[$product->id];
                $result = $product;
            }
        }

        return response()->json($result);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  list of products
     * @return two arrays of unique ids and products filtered
     */
    private function filterProductsArray($products){

        $productsList = [];
        $uniqueIds = [];
        foreach($products as $product){

            if(!array_key_exists($product->id,$uniqueIds)){
                $uniqueIds[$product->id] = 1;
                array_push($productsList ,$product);
            }else{
                $uniqueIds[$product->id] = $uniqueIds[$product->id] + 1;
            }
        }

        return array($productsList,$uniqueIds);
    }

    private function getOnlyIds($products){
        $productIds = [];
        foreach($products as $product){
            array_push($productIds ,$product->id);
        }
        return $productIds;
    }
}
