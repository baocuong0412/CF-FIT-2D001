<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();

        $userSystem = User::updateOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make('!password-123'),
            ]
        );

        Auth::login($userSystem);

        return redirect()->route('/');
    }
}
