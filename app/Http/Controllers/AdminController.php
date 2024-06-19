<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function viewAdminLogin() {
        if (Auth::guard('admin')->check()) {
            return redirect('/');
        }

        return view('admin.login', ['title' => 'Sparkling Laundry | Admin Login']);
    }

    public function viewDetailAdmin() {
        if (!Auth::guard('admin')->check()) {
            return redirect('/');
        }

        $user = Auth::guard('admin')->user();

        return view('admin.detail', ['title' => 'Sparkling Laundry | Detail Admin' . $user->name, 'user' => $user]);
    }

    public function adminLoginHandling(Request $request) {
        if (Auth::guard('admin')->check()) {
            return redirect('/');
        }

        $data = $request->validate([
            'email' => 'required|email',
            'password' => ['required', Password::min(4)]
        ]);

        if (Auth::guard('admin')->attempt($data)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'login' => 'Gagal login'
        ]);
    }

    public function adminUpdateHandling(Request $request) {
        if (!Auth::guard('admin')->check()) {
            return redirect('/');
        }
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required|ascii',
            'email' => 'required|email:rfc,dns,spoof',
            'password' => 'required|current_password:admin',
        ]);

        $user = Auth::guard('admin')->user();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if ($user->save()) {
            $request->session()->flash('update', true);
        } else {
            $request->session()->flash('update', false);
        }

        return redirect('/admin/detail');
    }

    public function adminLogoutHandling(Request $request) {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
