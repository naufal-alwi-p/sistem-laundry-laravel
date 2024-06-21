@extends('template.main')

@section('content')
    <div class="container">
        <div class="card mt-5 mb-4 shadow">
            <div class="card-body">
                <h1 class="card-title text-center">Detail Pesanan</h1>

                <p class="fs-5 text-center"><b>Status:</b> {{ $pesanan->status }}</p>

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

            </div>
        </div>

        @if ($pesanan->status === App\StatusPesanan::selesai && $pesanan->ulasan === null)
        {{-- @if (true) --}}
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h2 class="card-title text-center">Penilaian Layanan</h2>

                    <form action="/user/ulasan/{{ $pesanan->id }}" method="post">
                        @csrf
                        <div>
                            <p class="fs-4 m-0 text-center">Rating</p>
        
                            <div style="width: fit-content;" class="mx-auto">
                                <input type="radio" class="btn-check" name="rating" value="1" id="rating1" required>
                                <label class="fs-3 self-star" for="rating1"><i class="bi bi-star-fill"></i></label>
        
                                <input type="radio" class="btn-check" name="rating" value="2" id="rating2" required>
                                <label class="fs-3 self-star" for="rating2"><i class="bi bi-star-fill"></i></label>
        
                                <input type="radio" class="btn-check" name="rating" value="3" id="rating3" required>
                                <label class="fs-3 self-star" for="rating3"><i class="bi bi-star-fill"></i></label>
        
                                <input type="radio" class="btn-check" name="rating" value="4" id="rating4" required>
                                <label class="fs-3 self-star" for="rating4"><i class="bi bi-star-fill"></i></label>
        
                                <input type="radio" class="btn-check" name="rating" value="5" id="rating5" required>
                                <label class="fs-3 self-star" for="rating5"><i class="bi bi-star-fill"></i></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ulasan" class="form-label fs-5"><b>Ulasan:</b></label>
                            <textarea name="pesan" id="ulasan" rows="5" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark ms-auto d-block px-5">Kirim</button>
                    </form>
                </div>
            </div>
        @elseif ($pesanan->status === App\StatusPesanan::selesai && $pesanan->ulasan !== null)
        {{-- @elseif (true) --}}
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h2 class="card-title text-center">Penilaian Layanan</h2>
                        <div>
                            <p class="fs-4 m-0 text-center">Rating</p>
        
                            <div style="width: fit-content;" class="mx-auto">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $pesanan->ulasan->rating)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @else
                                    <i class="bi bi-star-fill"></i>
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
