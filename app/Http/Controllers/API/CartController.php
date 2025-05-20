<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function add_cart(Request $request)
    {
        $request->validate([
            'color_id' => 'required',
            'size_id' => 'required',
        ], [
            'color_id.required' => 'Please Select Color',
            'size_id.required' => 'Please Select Size',
        ]);

        Cart::insert([
            'customer_id' => $request->customer_id,
            'product_id' => $request->productid,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => 'Product added to cart',
        ]);
    }

    function cart($id){
        $carts = Cart::where('customer_id', $id)->get();

        return response()->json([
            'carts'=>$carts,
        ]);
    }
}
