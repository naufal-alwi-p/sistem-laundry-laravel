<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function viewUserLogin() {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('user.login', ['title' => 'Sparkling Laundry | User Login']);
    }

    public function viewUserRegister() {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('user.register', ['title' => 'Sparkling Laundry | User Register']);
    }

    public function viewDetailUser() {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        return view('user.detail', ['title' => 'Sparkling Laundry | Detail Akun' . $user->name, 'user' => $user]);
    }

    public function userRegisterHandling(Request $request) {
        if (Auth::check()) {
            return redirect('/');
        }

        $data = $request->validate([
            'name' => 'required|ascii',
            'email' => 'required|email:rfc,dns,spoof',
            'telepon' => 'required|numeric|digits_between:11,15',
            'password' => ['required', Password::min(4)],
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'jarak' => 'required|numeric|decimal:0,3'
        ]);

        $new_user = User::create($data);

        Auth::login($new_user);

        $request->session()->regenerate();

        return redirect()->intended('/');

    }

    public function userLoginHandling(Request $request) {
        if (Auth::check()) {
            return redirect('/');
        }

        $data = $request->validate([
            'email' => 'required|email',
            'password' => ['required', Password::min(4)]
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'login' => 'Gagal login'
        ]);
    }

    public function userUpdateHandling(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }
        $data = $request->validate([
            'name' => 'required|ascii',
            'email' => 'required|email:rfc,dns,spoof',
            'telepon' => 'required|numeric|digits_between:11,15',
            'password' => 'required|current_password',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'jarak' => 'required|numeric|decimal:0,3'
        ]);

        $user = Auth::user();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->telepon = $data['telepon'];
        $user->latitude = $data['latitude'];
        $user->longitude = $data['longitude'];
        $user->jarak = $data['jarak'];

        if ($user->save()) {
            $request->session()->flash('update', true);
        } else {
            $request->session()->flash('update', false);
        }

        return redirect('/user/detail');
    }

    public function userLogoutHandling(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
