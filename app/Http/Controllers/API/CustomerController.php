<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => ['required', 'unique:customers'],
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);

        try {
            Customer::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json([
                'message' => 'Successfully Registered',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'something went wrong',
            ]);
        }
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();
        if (! $customer || ! Hash::check($request->password, $customer->password)) {
            return response()->json([
                'error' => 'The provided credentials are incorrect.',
            ], 401);
        }
        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token'=> $token,
        ]);
    }

    function getcustomerinfo(){
        
    }

    function authenticated(){
        $status = Auth::check() ? true:false;
        return response()->json([
            'status'=>$status,
        ]);
    }
}
