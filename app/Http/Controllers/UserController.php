<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register()
    {
        return view('users.register');
    }
    public function store(UserRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        return redirect('/');
    }

    public function login()
    {
        return view('users.login');
    }

    public function attempt(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                Auth::login($user);
                return redirect('/');
            }
        }
        return redirect()->back()->withErrors(['email' => 'Wrong email or password']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}