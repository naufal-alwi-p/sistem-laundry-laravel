<?php

namespace App\Http\Controllers;

use App\Models\JenisCucian;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\User;
use App\StatusPesanan;
use Illuminate\Database\Eloquent\Builder;
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

    public function viewUserDashboard() {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        $pesanan_aktif = $user->semuaPesanan()->where(function (Builder $query) {
            $query->where('status', '<>', StatusPesanan::selesai)->orWhere('status', '<>', StatusPesanan::batal);
        })->get();

        $riwayat_pesanan = $user->semuaPesanan()->where('status', StatusPesanan::selesai)->where('status', StatusPesanan::batal)->limit(5)->get();

        $data = [
            'title' => 'Dashboard ' . $user->name . ' | Sparkling Laundry',
            'pesanan_aktif' => $pesanan_aktif,
            'riwayat_pesanan' => $riwayat_pesanan
        ];

        return view('user.dashboard', $data);
    }

    public function viewBuatPesanan() {
        if (!Auth::check()) {
            return redirect('/');
        }
        
        $data = [
            'title' => 'Buat Pesanan Laundry | Sparkling Laundry',
            'jenis_cucian' => JenisCucian::all()
        ];

        return view('user.buat_pesanan', $data);
    }

    public function viewDetailPesanan(Pesanan $pesanan) {
        if (!Auth::check()) {
            return redirect('/');
        }

        $data = [
            'title' => 'Pesanan ' . $pesanan->id . ' | Sparkling Laundry',
            'pesanan' => $pesanan,
            'user' => Auth::user()
        ];

        return view('user.detail_pesanan', $data);
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

    public function ulasanUserHandling(Request $request, Pesanan $pesanan) {
        if (!Auth::check()) {
            return redirect('/');
        }

        $data = $request->validate([
            'rating' => 'required|numeric|integer|min:0|max:5',
            'pesan' => 'required|string'
        ]);

        $ulasan = new Ulasan($data);

        if ($pesanan->ulasan()->save($ulasan)) {
            return redirect()->intended('/user/detail-pesanan/' . $pesanan->id);
        }
    }

    public function userLogoutHandling(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
