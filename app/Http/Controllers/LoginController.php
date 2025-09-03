<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('fail', 'email atau password salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu berhasil Logout');
    }

    public function register() {
        return view('auth.register');
    }

    public function register_proses(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        User::create($data);

        return redirect()->route('login');
    }
}
