<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::with('products')->get();
        return response()->json($categories);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json($category, 201);
    }

    /*public function show($id){
        $category = Category::with('products')->findOrFail($id);
        return response()->json($category);
    }*/

    public function show(Category $category){
        $category -> load('products');
        return response()->json($category);
    }

    public function update($id, Request $request){

        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()->json($category);
    }

    public function destroy($id) {
        
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Categoria eliminada correctamente'
        ]);
    }

}
