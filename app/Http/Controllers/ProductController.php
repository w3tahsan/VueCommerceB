<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Gallery;
use App\Models\inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $tags = Tag::all();
        return view('backend.product.add', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'tags'=>$tags,
        ]);
    }

    function store_product(Request $request){
        $tag_id = implode(',', $request->tag_id);

        $preview = $request->preview;
        $extension = $preview->extension();
        $file_name = uniqid().'.'.$extension;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($preview);
        $image->scale(width: 600);
        $image->save(public_path('uploads/product/'.$file_name));

        $product_id = Product::insertGetId([
            'sku'=>random_int(4000000,90000000000),
            'product_name'=>$request->product_name,
            'slug'=>Str::lower(str_replace(' ', '-', $request->product_name)).'-'.random_int(1000000,20000000),
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'short_desp'=>$request->short_desp,
            'discount'=>$request->discount,
            'tag_id'=>$tag_id,
            'long_desp'=>$request->long_desp,
            'preview'=>$file_name,
        ]);


        foreach($request->gallery as $gallery){
            $extension = $gallery->extension();
            $file_name = uniqid().'.'.$extension;

            $manager = new ImageManager(new Driver());
            $image = $manager->read($gallery);
            $image->scale(width: 600);
            $image->save(public_path('uploads/product/gallery/'.$file_name));

            Gallery::insert([
                'product_id'=>$product_id,
                'gallery'=>$file_name,
            ]);
        }
        return back();
    }

    function product_list(){
        $products = Product::all();
        return view('backend.product.list', [
            'products'=>$products,
        ]);
    }

    function add_variation(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('backend.product.variation', [
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }
    function add_color(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return back();
    }
    function add_size(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
        ]);
        return back();
    }

    function inventory($id){
        $colors = Color::all();
        $sizes = Size::all();
        $product = Product::find($id);
        $inventories = inventory::where('product_id', $id)->get();
        return view('backend.product.inventory', [
            'colors'=>$colors,
            'sizes'=>$sizes,
            'product'=>$product,
            'inventories'=>$inventories,
        ]);
    }
    function inventory_store(Request $request, $id){
        $product = Product::find($id);

        if(inventory::where('product_id', $id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            inventory::where('product_id', $id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back();
        }

        inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'price'=>$request->price,
            'discount_price'=>$request->price -  ($request->price * $product->discount / 100),
            'quantity'=>$request->quantity,
        ]);
        return back();
    }

    function del_inventory($id){
        inventory::find($id)->delete();
        return back();
    }
}
