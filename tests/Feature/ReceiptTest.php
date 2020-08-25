<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\AppTransaction;
use App\Product;
use Symfony\Component\HttpFoundation\Response;

class ReceiptTest extends TestCase
{
    /**
     * find one receipt after transaction success
     *
     * @return void
     */
    public function testFindOneReceipt()
    {
        $user = User::find(2);
        $product1 = Product::find(9);
        $product2 = Product::find(3);
        $products = [$product1,$product2];

        $appTransaction = new AppTransaction;
        $appTransaction->user_id = $user->id;
        $appTransaction->statusCode = 201;
        $appTransaction->status = 'COMPLETED';
        $appTransaction->orderId = '3EF94855N2400825J';
        $appTransaction->intent = 'CAPTURE';
        $appTransaction->total = 299;
        $appTransaction->products = $products;
        $appTransaction->save();

        $response = $this->actingAs($user)
                         ->get('/receipts');

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('</receipts>');
        $response->assertSee($appTransaction->total);
 
    }


      /**
     * find no receipt after transaction failed
     *
     * @return void
     */
    public function testFindNoReceipt()
    {
        $user = User::find(3);
        $product1 = Product::find(9);
        $product2 = Product::find(3);
        $products = [$product1,$product2];

        $appTransaction = new AppTransaction;
        $appTransaction->user_id = $user->id;
        $appTransaction->statusCode = 201;
        $appTransaction->status = 'CREATED';
        $appTransaction->orderId = '3EF94855N2400825J';
        $appTransaction->intent = 'CAPTURE';
        $appTransaction->total = 299;
        $appTransaction->products = $products;
        $appTransaction->save();

        $response = $this->actingAs($user)
                         ->get('/receipts');

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('</receipts>');
        $response->assertDontSee($appTransaction->total);
 
    }
}
