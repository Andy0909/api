<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $form = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        try{
            $user = User::create([
                'name' => $form['name'],
                'email' => $form['email'],
                'password' => Hash::make($form['password'])
            ]);
            $token = $user->createToken('token')->plainTextToken;
            $response =[
                'user' => $user,
                'token' => $token
            ];
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        return response($response,201);
    }

    public function login(Request $request)
    {
        $form = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        try{
            $user = User::where('email','=',$form['email'])->first();
            if(!$user || !Hash::check($form['password'],$user->password)){
                return response('登入失敗',401);
            }
            
            $token = $user->createToken('token')->plainTextToken;
            $response =[
                'user' => $user,
                'token' => $token
            ];
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => '您已登出'
        ];
    }
}
