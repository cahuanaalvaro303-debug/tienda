<?php

namespace App\Http\Controllers;

use App\models\Tag;

use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function index(){
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $tag = Tag::create([
            'name' => $request->name,
        ]);
        
        return response()->json($tag, 201);
    }

    public function show(Tag $tag){
        $tag->load('products');

        return response()->json($tag);
    }

    public function update(Tag $tag, Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag->update([
            'name' -> $request->name
        ]);

        return response()->json($tag);
    }

    public function destroy(Tag $tag){
        $tag->delete();

        return response()->json([
            'message'=> 'Tag eliminado correctamente'
        ]);
    }
}
