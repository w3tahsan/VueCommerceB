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
            'token' => $token,
        ]);
    }

    function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'User Logged Out Successfully',
            ], 200);
        } else {
            return response()->json([
                'message
                ' => 'Already Logged Out',
            ], 200);
        }
    }

    function customer_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        if ($request->current_password == '') {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);
            try {
                $customer = Customer::find($id);
                Customer::find($customer->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                ]);
                return response()->json([
                    'success' => 'Customer Updated'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => 'something went wrong',
                ]);
            }
        } else {
            try {
                $customer = Customer::find($id);
                if (password_verify($request->current_password, $customer->first()->password)) {
                    Customer::find($customer->id)->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'address' => $request->address,
                    ]);
                    return response()->json([
                        'success' => 'Customer Updated'
                    ]);
                } else {
                    return response()->json([
                        'passErr' => 'Current Password not Matched'
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => 'something went wrong',
                ]);
            }
        }
    }
}
