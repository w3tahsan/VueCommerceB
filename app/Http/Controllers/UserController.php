<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    function edit_profile(){
        return view('backend.users.edit');
    }
    function update_profile(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return back();
    }
    function update_password(Request $request){
        $request->validate([
            'current_password'=>'required',
            'password'=>['required','confirmed', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ],
            'password_confirmation'=>'required',
        ],[
            'current_password.required'=>'current password dibi kina bol',
            'password.required'=>'password dibi kina bol',
        ]);


        if(password_verify($request->current_password, Auth::user()->password)){
           User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
           ]);
           return back()->with('success', 'Password Changed Successfully');
        }
        else{
            return back()->with('err', 'Current Password not match');
        }
    }

    function update_photo(Request $request){

        if(Auth::user()->photo != null){
            $delete_from = public_path('uploads/user/'.Auth::user()->photo);
            unlink($delete_from);
        }

        $photo = $request->photo;
        $extension = $photo->extension();
        $file_name = uniqid().'.'.$extension;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($photo);
        $image->scale(width: 300);
        $image->save(public_path('uploads/user/'.$file_name));

        User::find(Auth::id())->update([
            'photo'=>$file_name,
        ]);

        return back();

    }
}
