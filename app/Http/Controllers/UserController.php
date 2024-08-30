<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function updateProfile(Request $request)
    {
        
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
        ]);


        $user = $request->user();
        

        if ($request->has('first_name')) {
            $user->first_name = $request->input('first_name');
        }
        if ($request->has('last_name')) {
            $user->last_name = $request->input('last_name');
        }
        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['user' => $user]);
    }

    public function updateProfileAvatar(Request $request){
        $user = $request->user();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time().'.'.$avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $avatarName);
            $user->avatar = 'avatars/'.$avatarName;
        }
        $user->save();

        return response()->json(['user' => $user]);
    }
}

