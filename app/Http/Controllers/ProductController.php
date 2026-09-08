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
    //  PRIMERA FORMA  PARA CREAR UN NUEVO REGISTRO
    /*public function store(Request $request) {
        
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
    }*/

    //SEGUNDA FORMA PARA CREAR UN NUEVO REGISTRO
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return response()->json($product, 201);
    }
    
    //PRIMERA FORMA PARA LEER UN UNICO REGISTRO 
   /* public function show($id) {

        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }
        return response()->json($product);
    }*/

    //SEGUNA FORMA PARA LEER REGISTRO EN ESPECIFICO
    public function show($id) {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    //PRIMEA FORMA PARA ACTUALIZAR DATOS 
    /*public function update($id, Request $request) {
        
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
    }*/

    //SEGUNDA FORMA PARA ACTUALIZAR O MODIFICAR DATOS 

    public function update($id, Request $request){
        $product = Product::finfOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product->name = $requets->name;
        $product->price = $requets->price;
        $product->stock = $request->stock;

        $product->save();

        return response()->json($product);

    }


    //PRIMERA FORMA PARA ELIMINAR UN REGISTRO
    /*public function destroy($id) {
       
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
    }*/

    //SEGUNDA FORMA PARA ELIMINAR UN REGISTRO
    public function destroy($id){
        $product = Product::findOrFail($id);

        $product->delete();
        return response()->json([
            'message'=> 'Producto eliminado correctamente'
        ]);
    }
}
