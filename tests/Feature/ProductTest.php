<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends TestCase
{
    /**
     * Teste que Index Product fonctionne
     *
     * @return void
     */
    public function testIndexProductPage200()
    {
        // Se login en tant que l'admin
        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->get('/product');

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('Liste des produits');
        $response->assertSee(Product::find(1)->name);
    }

    /**
     * Test la structure du JSON retourné dans Index
     *
     * @return void
     */
    public function testIndexProduct200()
    {
        // Authentifie en tant qu'un utilisateur (Celui avec l'ID 1, admin)
        $user = User::find(1);
        $response = $this->actingAs($user)->json('GET', '/product/index');

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' =>  [
                    "id",
                    "name",
                    "code",
                    "category_id",
                    "description",
                    "created_at",
                    "updated_at",
                ]
            ]);
    }


    /**
     * Get un produit et s'assure d'avoir reçu le bon produit
     *
     * @return void
     */
    public function testShowProduct200()
    {
        $idProduct = 1;

        $user = User::find(3);
        $response = $this->actingAs($user)
                         ->json('GET', '/product/' . $idProduct);

        $product = Product::find($idProduct);

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Id')
            ->assertSee('Code')
            ->assertSee('Nom')
            ->assertSee('Description')
            ->assertSee('Id de la Catégorie');
    }

    /**
     * Get une product qui n'existe pas et s'assure d'avoir reçu un code 404
     *
     * @return void
     */
    public function testShowProduct404()
    {
        $idProduct = 99999999;

        $user = User::find(3);
        $response = $this->actingAs($user)
                         ->json('GET', '/product/' . $idProduct);

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertSee('404');
    }



}
