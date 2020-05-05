<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use App\Product;
use App\User;

class CartTest extends TestCase
{
    /**
     * add product to user cart and verify it exist
     *
     * @return void
     */
    public function testCartHaveOneProduct()
    {
        $user = User::find(1);
        $product = Product::find(1);
        $cart = $user->cart;
        $cart->products()->attach($product->id);
        $cart->save();

        $response = $this->actingAs($user)
                         ->get('/cart');

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('</cart>');
        $response->assertSee($product->code);

    }

      /**
     * remove product from user cart and verify 
     * it's not the anymore
     *
     * @return void
     */
    public function testCartRemoveProduct()
    {
        $user = User::find(1);
        $product = Product::find(1);
        
        $cart = $user->cart;
        $cart->products()->attach([2,3,4,5,6,6,6,6,8]);
        $cart->save();

        $this->actingAs($user)
                         ->delete('/cart/'.$cart->id.'/'.$product->id);

        $response = $this->actingAs($user)
                         ->get('/cart');

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('</cart>');
        $response->assertDontSee($product->code);

    }
}
