<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    /**
     * Renvoie toutes les catégories
     *
     * @return Reponse JSON
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Renvoie la page d'affichage de toute les catégories
     *
     * @return Response VIEW
     */
    public function indexPage()
    {
        $categories = Category::all();
        return view('category/index')
            ->with(['categories' => $categories,'message' =>'']);
    }

    /**
     * Renvoie la catégorie ayant le ID donné
     *
     * @return Response JSON
     */
    public function show($id)
    {
        $category = Category::find($id);
        // Retourne une erreur quand Category n'est pas trouvé
        if (!$category) return parent::notFoundResponse();

        return response()->json($category);
    }

    /**
     * Affiche la page de modification d'une catégorie
     *
     * @return Response VIEW
     */
    public function edit($id)
    {
        $category = Category::find($id);
        // Retourne une erreur quand Category n'est pas trouvé
        if (!$category) abort(Response::HTTP_NOT_FOUND);

        return view('category/update')
            ->with(['category' => $category,'message' =>'']);
    }

    /**
     * Enregistre une nouvelle catégorie
     *
     * @return Response JSON
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|required|max:50',
            'description' => 'string|required|max:250',
        ]);

        Category::create($validatedData);

        return response()->json([
            "code" => Response::HTTP_CREATED,
            "message" => __('category.created') , // TODO: Traduire
        ], Response::HTTP_CREATED);
    }

    /**
     * Enregistre les modifications d'une catégorie dont l'ID est donné
     *
     * @return Response VIEW
     */
    public function update(Request $request,$id){

        $validatedUpdatedData = $request->validate([
            'name' => 'string|required|max:50',
            'description' => 'string|required|max:250',
        ]);

        $category = Category::find($id);

        // Retourne une erreur quand Category n'est pas trouvé (JSON)
        if (!$category) return parent::notFoundResponse();


        // Modifie les champs
        $category->name = $validatedUpdatedData["name"];
        $category->description = $validatedUpdatedData["description"];
        $category->save();

        return view('category/index')
            ->with([
                'categories' => Category::all(),
                'message' => __('category.updated') // TODO: Traduire
            ]);
    }

    /**
     * Efface une catégorie dont l'ID est donné
     *
     * @return Response JSON
     */
    public function destroy($id){
        $category = Category::find($id);
        // Retourne une erreur quand Category n'est pas trouvé (JSON)
        if (!$category) return parent::notFoundResponse();

        $category->delete();
        return response()->json([
            "message" => "category deleted !", // TODO: Traduire
        ]);
    }

}
