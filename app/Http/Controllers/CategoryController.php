<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{   
    public function index(){
      $categories = Category::all();
      return response()->json($categories);
    }

    public function indexPage(){
      $categories = Category::all();
      return view('category/index')->with(['categories' => $categories,'message' =>'']);
    }

    public function show($id){

      $category = Category::find($id);
      return response()->json($category);
    }

    public function edit($id){
      $category = Category::find($id);
      return view('category/update')->with('category', $category);
   }

    public function store(Request $request){
 
      $validatedData = $request->validate([
        'name' => 'string|required|max:50',
        'description' => 'string|required|max:250',
      ]);

      Category::create($validatedData);
      return response()->json("category created !"); 
    }

    public function update(Request $request,$id){

      $validatedUpdatedData = $request->validate([
        'name' => 'string|required|max:50',
        'description' => 'string|required|max:250',
      ]);

      $category = Category::find($id);

      $category->name = $validatedUpdatedData["name"];
      $category->description = $validatedUpdatedData["description"];
      $category->save();
      return view('category/index')->with(['categories' => Category::all(),'message' =>'category updated!']);
    }

    public function destroy($id){

      $category = Category::find($id);
      $category->delete();
      return response()->json("category deleted !");
    }


}
