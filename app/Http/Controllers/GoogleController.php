<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\user;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoole(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $user       = Socialite::driver('google')->user();
            $findUser   = User::where('google_id',$user->id)->first();
            if(!empty($findUser)){
                Auth::login($findUser);
                return redirect('home');
            }else{
                $newUser = User::create([
                    'name'=>$user->name,
                    'username'=>$user->email,
                    'email'=>$user->email,
                    'google_id'=>$user->id,
                    'role'=>'user',
                    'password'=> bcrypt('12345678')
                ]);
                // dd($newUser);
                Auth::login($newUser);
                return redirect('home');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
