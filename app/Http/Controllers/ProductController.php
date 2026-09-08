<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index() {

        $products = Product::all();
        return response()->json($products);

    }

    public function store(Request $request) {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' =>'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]); 

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();

        return response()->json($product, 201);
    }

    public function show($id) {

        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }
        return response()->json($product);
    }

    public function update($id, Request $request) {
        
        $product = Product::find($id);

        if(!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', 
            'stock' => 'required|integer|min:0'
        ]);
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
        return response()->json($product);
    }

    public function destroy($id) {
        $product = Product::find($id);

        if(!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();
        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ]);
    }
}
