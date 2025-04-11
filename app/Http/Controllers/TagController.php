<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function tags(){
        $tags = Tag::all();
        return view('backend.tag.tag', [
            'tags'=>$tags,
        ]);
    }
    function tags_store(Request $request){
        foreach($request->tag_name as $tag){
            Tag::insert([
                'tag_name'=>$tag,
            ]);
        }
        return back();
    }
}
