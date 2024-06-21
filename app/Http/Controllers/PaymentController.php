<?php

namespace App\Http\Controllers;

use App\Models\JenisCucian;
use App\Models\Pesanan;
use App\StatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function getHitungHargaPesanan(Request $request) {
        if (!Auth::check()) {
            return response()->json(['status' => 'Not Found'], 404);
        }

        $user = Auth::user();
        
        $jenis_cucian = JenisCucian::find($request->json('metode_id'));

        $hargaEkspedisi = 5000;

        $harga_laundry = ($jenis_cucian?->harga ?? 0) * $request->json('jumlah');

        $harga_antar = $request->json('antar') === 1 ? $user->jarak * $hargaEkspedisi : 0;

        $harga_jemput = $request->json('jemput') === 1 ? $user->jarak * $hargaEkspedisi : 0;

        $total = $harga_laundry + $harga_antar + $harga_jemput;

        return response()->json([
            'harga_laundry' => explode(',', Number::currency($harga_laundry, 'IDR', 'id'))[0],
            'harga_antar' => explode(',', Number::currency($harga_antar, 'IDR', 'id'))[0],
            'harga_jemput' => explode(',', Number::currency($harga_jemput, 'IDR', 'id'))[0],
            'total' => $total,
            'total_readable' => explode(',', Number::currency($total, 'IDR', 'id'))[0]
        ]);
    }

    public function paymentProcess(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }

        if ($request->has(['jenis_cucian_id', 'jumlah', 'jemput', 'antar', 'total_biaya'])) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $biaya = $request->integer('total_biaya');

            $params = array(
                'transaction_details' => array(
                    'order_id' => Str::orderedUuid(),
                    'gross_amount' => $biaya,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->telepon,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $data = [
                'title' => 'Pembayaran | Sparkling Laundry',
                'data_input' => $request->except('_token'),
                'snap_token' => $snapToken,
                'client_key' => env('MIDTRANS_CLIENT_KEY')
            ];

            return view('user.payment', $data);
        } else {
            return redirect('/user/dashboard');
        }
    }

    public function paymentNotificationHandling(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }

        // return response()->json($request->json()->all());

        if ($request->json('fraud_status') === 'accept' && ($request->json('transaction_status') === 'capture' || $request->json('transaction_status') === 'settlement')) {
            $bayar = $request->json('gross_amount');
            $data_input = $request->json('data_input');

            $user = Auth::user();
            $jenis_cucian = JenisCucian::find($data_input['jenis_cucian_id']);

            if ($user !== null && $jenis_cucian !== null) {
                Pesanan::create([
                    'id' => $request->json('order_id'),
                    'jenis_cucian_id' => $jenis_cucian->id,
                    'jumlah' => $data_input['jumlah'],
                    'status' => $data_input['jemput'] === 1 ? StatusPesanan::dijemput : StatusPesanan::sampaiToko,
                    'dijemput' => $data_input['jemput'],
                    'diantar' => $data_input['antar'],
                    'user_id' => $user->id,
                ]);

                $request->session()->flash('pesanan', true);
                return response()->json(['result' => true]);

            }
        } else {
            $request->session()->flash('pesanan', false);
            return response()->json(['result' => false]);
        }
    }
}
