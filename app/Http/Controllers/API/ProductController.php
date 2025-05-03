<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function product()
    {
        $products = Product::with('rel_to_inventories')->get();
        return response()->json([
            'products' => $products
        ]);
    }
    function new_product(){
        $new_products = Product::with('rel_to_inventories')->latest()->take(4)->get();
        return response()->json([
            'new_products' => $new_products
        ]);
    }
    function product_details($id){
        $product_details = Product::with([
            'rel_to_inventories.rel_to_color', 
            'rel_to_inventories.rel_to_size', 
            'galleries'
            ])->find($id);

        $tagIds = explode(',', $product_details->tag_id);
        $tags = Tag::whereIn('id', $tagIds)->get();

        return response()->json([
            'product_details' => $product_details,
            'tags' => $tags,
        ]);
    }
}
