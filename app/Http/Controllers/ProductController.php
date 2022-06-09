<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        return Product::when(request('search'),function($query){
            $query->where('name','like','%'.request('search').'%');
        })->orderBy('id','desc')->paginate(5);
    }

    public function show($id)
    {
        $exitingProduct = Product::find($id);
        if($exitingProduct){
            return $exitingProduct;
        }
        return "product not found";
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string',Rule::unique('products','name')],
            'price' => 'required|numeric',
        ]);

        $product =  Product::create([
            'name' => request('name'),
            'price' => request('price'),
        ]);

        return $product;
    }

    public function update($id)
    {
        $exitingProduct = Product::find($id);
        if($exitingProduct){
            request()->validate([
                "name" => ['required','string',Rule::unique('products','name')->ignore($id)],
                'price' => ['required','numeric'],
            ]);

            $exitingProduct->update(request()->only('name','price'));

            return $exitingProduct;
        }

        return 'product not found';
    }

    public function destroy($id)
    {
        $exitingProduct = Product::find($id);
        if($exitingProduct){
            $exitingProduct->delete();
            return "delete successfully";
        }

        return 'product not found';
    }
}
