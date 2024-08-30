<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function getUsers()
    {
        return response()->json(['users' =>  User::where('role', 1)->get()->toArray()]);
    }

    public function update_user_status(Request $request) {
        if(empty($request->id) || empty($request->status)){
            return response()->json(['error' =>  true]);
        }
        $users = User::find($request->id);
        $users->status = $request->status;

        if($users->save()){
            return response()->json(['success' =>  true]);
        }
        return response()->json(['error' =>  true]);
    }

    
}
