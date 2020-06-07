<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function all(Request $request)
    {
        $products = Product::all();

        return response() ->json([
            'success' => true,
            'products' => $products
        ], 201);        
    }    

    public function show(Request $request, Product $product)
    {
        return response() ->json([
                'success' => true,
                'product' => $product,
            ], 201);
    }
}
