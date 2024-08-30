<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleAuthController extends Controller
{
     public function redirect (){
        return Socialite::driver('google')->redirect();
     }

     public function callBackGoogle (){
        
        try{
            $google_user = Socialite::driver('google')->user();
 
            $google_id = $google_user->getId();
            $name = $google_user->getName();
            $nameParts = explode(' ', $name);

            $firstName = $nameParts[0]; 
            $lastName = $nameParts[1];  

            $email = $google_user->getEmail();
        
            $user = User::where('google_id', $google_id)->first();
           
            if(empty($user)){
                $user_data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'google_id' => $google_id,
                    'avatar' => $google_user->getAvatar()
                ];
               
                $new_user = User::create($user_data);
                
                Auth::login($new_user);
                return redirect()->intended('questions');
            }
            Auth::login($user);

            $redirect = '/profile'; 
            if($user['status'] == 1){
                 $redirect = '/questions';   
            }

            return redirect()->intended($redirect);
        }catch(\Throwable $th){
            dd('test'. $th->getMessages);
        }
     }
}
