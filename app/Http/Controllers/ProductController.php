<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product) {
        return response()->json($product,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $products = Product::where('name','like',"%$request->key%")
            ->orWhere('description','like',"%$request->key%")->get();

        return response()->json($products, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'string|required',
            'description' => 'string|required',
            'quantity' => 'numeric|required',
            'contained_in' => 'numeric',
            'price' => 'numeric|required',
            'manufactured_on' => 'date|required',
        ]);

        try {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'manufactured_on' => $request->manufactured_on,
                'user_id' => auth()->user()->id,
            ]);
            return response()->json($product, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Product $product) {
        try {
            $product->update($request->all());
            return response()->json($product, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->json(['message'=>'Product deleted.'],202);
    }

    public function index() {
        $products = Product::where('user_id', auth()->user()->id)->orderBy('name')->get();
        return response()->json($products, 200);
    }
}
