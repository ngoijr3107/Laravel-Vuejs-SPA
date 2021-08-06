<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        //
        return Product::when(request('search'), function($query){
            $query->where('name', 'like', '%' . request('search') . '%');
        })->orderBy('updated_at', 'desc')->paginate(10);
    }
  
    public function store(Request $request)
    {
        //
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric'
    ]);
    $product = Product::create($request->only('name', 'price'));
    return $product;
    }

  
    public function show($id)
    {
        //
        $product = Product::find($id);
        return $product;
    }

 
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);
        $product = Product::find($id);
        $product->update($request->only('name', 'price'));
        return $product;      
    }

   
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return $product;
    }
}
