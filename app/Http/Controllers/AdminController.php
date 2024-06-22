<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\StatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Builder;

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

    public function viewAdminDashboard() {
        if (!Auth::guard('admin')->check()) {
            return redirect('/');
        }

        $user = Auth::guard('admin')->user();

        $pesanan_aktif = Pesanan::where('status', '<>', StatusPesanan::selesai)->where('status', '<>', StatusPesanan::batal)->get();

        $riwayat_pesanan = Pesanan::where('status', StatusPesanan::selesai)->orWhere('status', StatusPesanan::batal)->limit(5)->get();

        $data = [
            'title' => 'Admin ' . $user->name . ' Dashboard | Sparkling Laundry',
            'pesanan_aktif' => $pesanan_aktif,
            'riwayat_pesanan' => $riwayat_pesanan
        ];

        return view('admin.dashboard', $data);
    }

    public function adminViewDetailPesanan(Pesanan $pesanan) {
        if (!Auth::guard('admin')->check()) {
            return redirect('/');
        }

        $data = [
            'title' => 'Pesanan ' . $pesanan->id . ' | Sparkling Laundry',
            'pesanan' => $pesanan,
            'user' => $pesanan->user
        ];

        return view('admin.detail_pesanan', $data);
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

    public function updateStatusPesananHandling(Request $request, Pesanan $pesanan) {
        if (!Auth::guard('admin')->check()) {
            return redirect('/');
        }

        $data = $request->validate([
            'status' => ['required', Rule::enum(StatusPesanan::class)]
        ]);

        $pesanan->status = $data['status'];

        if ($pesanan->save()) {
            $request->session()->flash('status', true);
        } else {
            $request->session()->flash('status', false);
        }

        return redirect()->intended('/admin/user-detail-pesanan/' . $pesanan->id);
    }

    public function adminLogoutHandling(Request $request) {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
