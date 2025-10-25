<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function registr(Request $request){
        $user = $request->validate([
            'name' => 'required',
            'email'=> 'email|required|unique:users',
            'password' => 'required|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);
        return response()->json($user);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email'=> 'email|required',
            'password'=>'required|min:6'
        ]);

        if(Auth::attempt($credentials)){
            $token = $request -> user() -> createToken('MyAppToken') -> plainToText;
            return response() -> json($token); 
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request -> user() -> tokens() -> delete();
        return response('logout'); 
    }
}
