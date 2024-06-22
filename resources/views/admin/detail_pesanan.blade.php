@extends('template.main')

@section('content')
    <div class="container">
        @if (session('status') === true)
            <div class="alert alert-success alert-dismissible mt-4 fade show" role="alert">
                Status berhasil di update.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('status') === false)
            <div class="alert alert-danger alert-dismissible mt-4 fade show" role="alert">
                Status gagal di update.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mt-5 mb-4 shadow">
            <div class="card-body">
                <h1 class="card-title text-center">Detail Pesanan</h1>

                @if ($pesanan->status === App\StatusPesanan::selesai->value || $pesanan->status === App\StatusPesanan::batal->value)
                    <p class="fs-5 text-center"><b>Status:</b> {{ $pesanan->status }}</p>
                @else
                    <form action="/admin/update-status-pesanan/{{ $pesanan->id }}" method="post" id="update-status">
                        @csrf
                        <div class="fs-5 text-center">
                            <label for="status" class="form-label"><b>Status:</b></label>
                            <select name="status" id="status" class="form-select d-inline" style="width: fit-content;">
                                <option @selected($pesanan->status === App\StatusPesanan::dijemput->value) value="{{ App\StatusPesanan::dijemput }}">{{ App\StatusPesanan::dijemput }}</option>
                                <option @selected($pesanan->status === App\StatusPesanan::sampaiToko->value) value="{{ App\StatusPesanan::sampaiToko }}">{{ App\StatusPesanan::sampaiToko }}</option>
                                <option @selected($pesanan->status === App\StatusPesanan::diproses->value) value="{{ App\StatusPesanan::diproses }}">{{ App\StatusPesanan::diproses }}</option>
                                <option @selected($pesanan->status === App\StatusPesanan::packing->value) value="{{ App\StatusPesanan::packing }}">{{ App\StatusPesanan::packing }}</option>
                                <option @selected($pesanan->status === App\StatusPesanan::kirimKeRumah->value) value="{{ App\StatusPesanan::kirimKeRumah }}">{{ App\StatusPesanan::kirimKeRumah }}</option>
                                <option @selected($pesanan->status === App\StatusPesanan::selesai->value) value="{{ App\StatusPesanan::selesai }}">{{ App\StatusPesanan::selesai }}</option>
                                <option @selected($pesanan->status === App\StatusPesanan::batal->value) value="{{ App\StatusPesanan::batal }}">{{ App\StatusPesanan::batal }}</option>
                            </select>
                        </div>
                    </form>
                @endif

                <hr>

                <div class="mb-3">
                    <p class="m-0"><b>ID Pesanan:</b></p>
                    <p class="m-0">{{ $pesanan->id }}</p>
                </div>

                <div class="mb-3 row">
                    <div class="col-4">
                        <p class="m-0"><b>Jenis Cucian</b></p>
                        <p class="m-0">{{ $pesanan->jenisCucian->nama }}</p>
                    </div>
                    <div class="col-3 offset-5 offset-lg-0">
                        <p class="m-0"><b>Jumlah</b></p>
                        <p class="m-0">{{ $pesanan->jumlah }}</p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-3">
                        <p class="m-0"><b>Dijemput:</b></p>
                        <p class="m-0">{{ $pesanan->dijemput === 1 ? 'Ya' : 'Tidak' }}</p>
                    </div>
                    <div class="col-3 offset-6 offset-lg-1">
                        <p class="m-0"><b>Diantar:</b></p>
                        <p class="m-0">{{ $pesanan->diantar === 1 ? 'Ya' : 'Tidak' }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="m-0"><b>Total Harga:</b></p>
                    <p class="m-0">{{ explode(',', Illuminate\Support\Number::currency($pesanan->jumlah * $pesanan->jenisCucian->harga + ( $pesanan->dijemput === 1 ? $user->jarak * 5000 : 0 ) + ( $pesanan->diantar === 1 ? $user->jarak * 5000 : 0 ), 'IDR', 'id'))[0] }}</p>
                </div>

                @if ($pesanan->status !== App\StatusPesanan::selesai->value && $pesanan->status !== App\StatusPesanan::batal->value)
                    <button type="submit" class="btn btn-dark" form="update-status">Update Status</button>
                @endif

            </div>
        </div>

        @if ($pesanan->status === App\StatusPesanan::selesai->value && $pesanan->ulasan !== null)
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h2 class="card-title text-center">Penilaian Layanan</h2>
                        <div>
                            <p class="fs-4 m-0 text-center">Rating</p>
        
                            <div style="width: fit-content;" class="mx-auto">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $pesanan->ulasan->rating)
                                        <i class="bi bi-star-fill fs-3 text-warning"></i>
                                    @else
                                    <i class="bi bi-star-fill fs-3"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ulasan" class="form-label fs-5"><b>Ulasan:</b></label>
                            <textarea name="pesan" id="ulasan" rows="5" class="form-control" style="resize: none;" readonly>{{ $pesanan->ulasan->pesan }}</textarea>
                        </div>
                </div>
            </div>
        @elseif ($pesanan->status === App\StatusPesanan::selesai->value && $pesanan->ulasan === null)
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h2 class="card-title text-center">Penilaian Layanan</h2>
                        <div>
                            <p class="text-secondary-emphasis text-center">Tidak ada ulasan</p>
                        </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        const ratings = document.querySelectorAll(".self-star");
        const ratingsLength = ratings.length;

        ratings.forEach((rating, index) => {
            rating.onclick = (e) => {
                for (let i = 0; i < ratingsLength; i++) {
                    if (i <= index) {
                        ratings[i].classList.add('text-warning');
                    } else {
                        ratings[i].classList.remove('text-warning');
                    }
                }
            }
        });
    </script>
@endsection
