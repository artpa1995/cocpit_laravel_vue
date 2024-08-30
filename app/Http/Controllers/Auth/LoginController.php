<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

       
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->get()->first()->toArray();
            $request->session()->regenerate();
            $redirect = '/profile'; 
            if($user['status'] == 1){
                 $redirect = '/questions';   
            }
            return response()->json(['user' => $user, 'redirect' => $redirect]);
        }

        return response()->json(['error' => 'The provided credentials do not match our records.'], 422);
    }

    public function check_user(){
        $user = [];

        if(Auth::user()){
            $user = Auth::user();     
        }
        
        return response()->json(['user' => $user,]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['user' => 'out']);
    }

}
