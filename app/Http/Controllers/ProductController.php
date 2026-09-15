<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Request\UpdateProductRequest;
class ProductController extends Controller
{
    //
    /*public function index(Request $request){
        $products = Product::query();

        if($request->search) {
            $products->where('name', 'like', '%'.$request->search.'%');
        }

        return response()->json(
            $products->get()
        );
    }*/

    public function index(Request $request){
        $query = Product::with(['category', 'tags']);

        if($request->search){
            $query->where(
                'name', 'like', '%'.$request->search.'%'
            );
        }

        if($request->min_price){
            $query->where(
                'price', '>=', $request->min_price
            );
        }

        if($request->max_price){
            $query->where(
                'price', '<=', $request->max_price
            );
        }

        if($request->category_id){
            $query->where(
                'category_id', $request->category_id
            );
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json($products);
    }


    /*public function index() {

        //$products = Product::all();

        $products = Product::with('category')->get();
        return response()->json($products);

    }*/
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
    public function store(StoreProductRequest $request){
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);

        return response()->json($product, 201);
    }
    
    //PRIMERA FORMA PARA LEER UN UNICO REGISTRO 

    /*public function show($id) {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }*/

   public function show(Product $product) {

        return response()->json($product);
    }

    //SEGUNA FORMA PARA LEER REGISTRO EN ESPECIFICO
    /*public function show($id) {
        $product = Product::findOrFail($id);

        $product->load('category');

        return response()->json($product);
    }*/

    //PRIMEA FORMA PARA ACTUALIZAR DATOS 
    public function update(Product $product, UpdateProductRequest $request) {
        
        
        /*$product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;*/
        $product->update ([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);

        return response()->json($product);
    }

    //SEGUNDA FORMA PARA ACTUALIZAR O MODIFICAR DATOS 

    /*public function update($id, Request $request){
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

    }*/

    //TERCERA FORMA PARA PODER ACTUALIZAR REGISTROS 

    /*public function update($id, Request $request) {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);

        return response()->json($product);
    }*/


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
    public function destroy(Product $product){

        $product->delete();
        return response()->json([
            'message'=> 'Producto eliminado correctamente'
        ]);
    }

    public function syncTags(Product $product, Request $request)
    {
        $request->validate([
            'tag_ids' => 'required|array', 
            'tag_ids.*' => 'integer|exists:tags,id'
        ]);

        $product->tags()->sync($request->tag_ids);

        return response()->json([
            'message' => 'Tags actualizados correctamente', 
            'product' => $product->load('tags')
        ]);
    }
}
