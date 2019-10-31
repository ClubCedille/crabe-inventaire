<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class CategoryTest extends TestCase
{

    /**
     * Teste que Index Category fonctionne
     *
     * @return void
     */
    public function testIndexCategoryPage200()
    {
        // Se login et get sur la page category
        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->get('/category');

        // S'assure que les keys soient présentes dans la réponse
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('</category-component>');
        $response->assertSee(Category::find(1)->name);
    }

    /**
     * Test la structure du JSON retourné dans Index
     *
     * @return void
     */
    public function testIndexCategory200()
    {
        // Authentifie en tant qu'un utilisateur (Celui avec l'ID 1)
        $user = User::find(1);
        $response = $this->actingAs($user)->json('GET', '/category/index');

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' =>  [
                    "id",
                    "name",
                    "description",
                    "created_at",
                    "updated_at",
                ]
            ]);
    }

    /**
     * Get une category et s'assure d'avoir reçu la bonne catégory
     *
     * @return void
     */
    public function testShowCategory200()
    {
        $idCategory = 1;

        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->json('GET', '/category/' . $idCategory);

        $category = Category::find($idCategory);

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
            ]);
    }

    /**
     * Get une category qui n'existe pas et s'assure d'avoir reçu un code 404
     *
     * @return void
     */
    public function testShowCategory404()
    {
        $idCategory = 99999999;

        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->json('GET', '/category/' . $idCategory);

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                "error"=> Response::HTTP_NOT_FOUND,
                "message"=> "Not found",
            ]);
    }

    /**
     * Edit une category
     *
     * @return void
     */
    public function testEditCategory200()
    {
        $idCategory = 2;

        $user = User::find(1);

        $category = Category::find($idCategory);
        $oldName = $category->name;
        $newName = "Testing one two";

        $category->name = $newName;

        $response = $this->actingAs($user)
                         ->json('PUT', '/category/' . $idCategory,
                                $category->toArray());

        $response->assertStatus(Response::HTTP_OK);

        // S'assurer d'avoir modifié Category
        $updatedCategory = Category::find($idCategory);
        $this->assertTrue($updatedCategory->name == $newName);
        $this->assertTrue($updatedCategory->name != $oldName);
    }

    /**
     * Edit une category qui n'existe pas et s'assure d'avoir reçu un code 404
     *
     * @return void
     */
    public function testEditCategory404()
    {
        $idCategory = 99999999;

        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->json('GET', '/category/' . $idCategory);

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                "error"=> Response::HTTP_NOT_FOUND,
                "message"=> "Not found",
            ]);
    }

    /**
     * Créer une nouvelle category
     *
     * @return JSON
     */
    public function testStoreCategory201()
    {
        $this->withoutExceptionHandling();
        $user = User::find(1);
        $name = "Nom Bidon";
        $description = "Description Bidon";

        $response = $this->actingAs($user)
                         ->json('POST', '/category/', [
                             "name" => $name,
                             "description" => $description,
                         ]);

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                "code" => Response::HTTP_CREATED,
                "message" => "category created !",
            ]);

        // Assert que la Category est dans la DB et les infos sont bon
        $recentCategory = Category::orderBy('created_at', 'desc')->first();
        $this->assertEquals($recentCategory->name, $name);
        $this->assertEquals($recentCategory->description, $description);
    }

    /**
     * Créer une nouvelle category mais n'inclut pas les champs requis
     *
     * @return JSON
     */
    public function testDestroyCategory200()
    {
        $this->withoutExceptionHandling();
        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->json('DELETE', '/category/9');

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "message" => "category deleted !",
            ]);
    }

    /**
     * Créer une nouvelle category mais n'inclut pas les champs requis
     *
     * @return JSON
     */
    public function testDestroyCategory404()
    {
        $this->withoutExceptionHandling();
        $idCategory = 99999999;

        $user = User::find(1);
        $response = $this->actingAs($user)
                         ->json('DELETE', '/category/' . $idCategory);

        // S'assure que les keys soient présentes dans la réponse
        $response
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                "error"=> Response::HTTP_NOT_FOUND,
                "message"=> "Not found",
            ]);
    }

}
