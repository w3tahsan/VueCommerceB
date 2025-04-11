<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    function add_category(){
        $categories = Category::all();
        return view('backend.category.add', compact('categories'));
    }
    function category_store(Request $request){
        $request->validate([
            'category_name'=>['required', 'unique:categories'],
            'category_image'=>['required', 'extensions:jpg,png', 'max:512'],
        ],[
            'category_name.required'=>'oi beta category nam de',
            'category_image.required'=>'oi beta category image de',
        ]);

        $category_image = $request->category_image;
        $extension = $category_image->extension();
        $file_name = uniqid().'.'.$extension;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($category_image);
        $image->scale(width: 300);
        $image->save(public_path('uploads/category/'.$file_name));

        Category::insert([
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
        ]);
        return back();
    }

    function category_delete($id){
        // $cat = Category::find($id);
        // $delete_from = public_path('uploads/category/'.$cat->category_image);
        // unlink($delete_from);
        Category::find($id)->delete();
        return back();
    }

    function category_edit($id){
        $category = Category::find($id);
        return view('backend.category.edit', [
            'category'=>$category,
        ]);
    }

    function category_update(Request $request, $id){
        if($request->category_image != ''){
            $cat = Category::find($id);
            $delete_from = public_path('uploads/category/'.$cat->category_image);
            unlink($delete_from);

            $category_image = $request->category_image;
            $extension = $category_image->extension();
            $file_name = uniqid().'.'.$extension;
    
            $manager = new ImageManager(new Driver());
            $image = $manager->read($category_image);
            $image->scale(width: 300);
            $image->save(public_path('uploads/category/'.$file_name));

            Category::find($id)->update([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
            ]);
            return back();


        }
        else{
            Category::find($id)->update([
                'category_name'=>$request->category_name,
            ]);
            return back();
        }
    }   

    function category_restore($id){
        Category::onlyTrashed()->find($id)->restore();
        return back();
    }

    function category_pdelete($id){
        $cat = Category::onlyTrashed()->find($id);
        $delete_from = public_path('uploads/category/'.$cat->category_image);
        unlink($delete_from);
        Category::onlyTrashed()->find($id)->forceDelete();
        return back();
    }

    function trash(){
        $trashed = Category::onlyTrashed()->get();
        return view('backend.category.trash', [
            'trashed'=>$trashed,
        ]);
    }

    function delete_checked(Request $request){
        foreach($request->check as $category){
            Category::find($category)->delete();
        }

        return back();
    }

    function checked_action(Request $request){
       if($request->btun == 1){
            foreach($request->check as $category){
                Category::onlyTrashed()->find($category)->restore();
            }
            return back();
       }
       else {
        foreach($request->check as $category){
            $cat = Category::onlyTrashed()->find($category);
            $delete_from = public_path('uploads/category/'.$cat->category_image);
            unlink($delete_from);
            Category::onlyTrashed()->find($category)->forceDelete();
        }
        return back();
       }
    }










}
