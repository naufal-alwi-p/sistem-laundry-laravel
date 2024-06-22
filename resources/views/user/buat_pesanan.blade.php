@extends('template.main')

@section('content')
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Buat Pesanan</h1>

        <form action="/payment/process" method="post" class="mb-5" onsubmit="return validateForm()">
            @csrf
            <div class="mb-3">
                <label for="metode" class="form-label">Metode yang Dipilih:</label>
                <select class="form-select @error('jenis_cucian_id') is-invalid @enderror" name="jenis_cucian_id" id="metode" required>
                    <option value='-1' selected>Pilih metode laundry</option>
                    @foreach ($jenis_cucian as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama }} ({{ explode(',', Illuminate\Support\Number::currency($jenis->harga, 'IDR', 'id'))[0] }})</option>
                    @endforeach
                </select>
                @error('jenis_cucian_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Masukkan Berapa Banyak:</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" min="1" required>
                @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="row gx-5 mb-3">
                <div class="col-auto">
                    <label for="jemput" class="form-label">Jasa Jemput:</label>
                    <select class="form-select @error('jemput') is-invalid @enderror" name="jemput" id="jemput">
                        <option value="1">Ya</option>
                    </select>
                    @error('jemput')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-auto">
                    <label for="antar" class="form-label">Jasa Antar:</label>
                    <select class="form-select @error('antar') is-invalid @enderror" name="antar" id="antar">
                        <option selected value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                    @error('antar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <small>Biaya Ekspedisi per Km: Rp 5.000</small>
            </div>
            <div class="mb-3">
                <p class="fw-bold fs-5">Rincian</p>
                <div class="row">
                    <p class="col-md fw-bold">Harga Laundry:</p>
                    <p class="col-md text-start text-md-end" id="harga-laundry">Rp 0</p>
                </div>
                <div class="row">
                    <p class="col-md fw-bold">Biaya Antar:</p>
                    <p class="col-md text-start text-md-end" id="biaya-antar">Rp 0</p>
                </div>
                <div class="row">
                    <p class="col-md fw-bold">Biaya Jemput:</p>
                    <p class="col-md text-start text-md-end" id="biaya-jemput">Rp 0</p>
                </div>
                <hr>
                <div class="row">
                    <p class="col-md fw-bold">Total:</p>
                    <p class="col-md text-start text-md-end" id="total">Rp 0</p>
                    <input type="hidden" name="total_biaya" id="total_biaya" value="0">
                </div>
            </div>
            <button type="submit" class="btn btn-dark d-block ms-auto w-25">Pesan</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        const metodeInput = document.querySelector('#metode');
        const jumlahInput = document.querySelector('#jumlah');
        const jemputInput = document.querySelector('#jemput');
        const antarInput = document.querySelector('#antar');
        const hargaLaundry = document.querySelector('#harga-laundry');
        const biayaAntar = document.querySelector('#biaya-antar');
        const biayaJemput = document.querySelector('#biaya-jemput');
        const totalBiaya = document.querySelector('#total');
        const totalBiayaInput = document.querySelector('#total_biaya');

        jemputInput.onchange = () => {
            const metode_id = Number(metodeInput.options[metodeInput.selectedIndex].value);
            const jumlah = jumlahInput.value === '' ? 0 : Number(jumlahInput.value);

            const data = JSON.stringify({
                metode_id: metode_id,
                jumlah: jumlah,
                antar: Number(antarInput.value),
                jemput: Number(jemputInput.value)
            });

            const fetchPOST = fetch(`${window.location.origin}/get/harga-pesanan`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: data,
            });

            fetchPOST.then((respon) => {
                return respon.json();
            }).then((hasil) => {
                hargaLaundry.innerHTML = hasil.harga_laundry;
                biayaAntar.innerHTML = hasil.harga_antar;
                biayaJemput.innerHTML = hasil.harga_jemput;
                totalBiaya.innerHTML = hasil.total_readable;
                totalBiayaInput.value = hasil.total;
            }).catch((error) => {
                console.log(error);
            });
        };

        antarInput.onchange = () => {
            const metode_id = Number(metodeInput.options[metodeInput.selectedIndex].value);
            const jumlah = jumlahInput.value === '' ? 0 : Number(jumlahInput.value);

            const data = JSON.stringify({
                metode_id: metode_id,
                jumlah: jumlah,
                antar: Number(antarInput.value),
                jemput: Number(jemputInput.value)
            });

            const fetchPOST = fetch(`${window.location.origin}/get/harga-pesanan`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: data,
            });

            fetchPOST.then((respon) => {
                return respon.json();
            }).then((hasil) => {
                hargaLaundry.innerHTML = hasil.harga_laundry;
                biayaAntar.innerHTML = hasil.harga_antar;
                biayaJemput.innerHTML = hasil.harga_jemput;
                totalBiaya.innerHTML = hasil.total_readable;
                totalBiayaInput.value = hasil.total;
            }).catch((error) => {
                console.log(error);
            });
        };

        metodeInput.onchange = () => {
            const metode_id = Number(metodeInput.options[metodeInput.selectedIndex].value);
            const jumlah = jumlahInput.value === '' ? 0 : Number(jumlahInput.value);

            const data = JSON.stringify({
                metode_id: metode_id,
                jumlah: jumlah,
                antar: Number(antarInput.value),
                jemput: Number(jemputInput.value)
            });

            const fetchPOST = fetch(`${window.location.origin}/get/harga-pesanan`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: data,
            });

            fetchPOST.then((respon) => {
                return respon.json();
            }).then((hasil) => {
                hargaLaundry.innerHTML = hasil.harga_laundry;
                biayaAntar.innerHTML = hasil.harga_antar;
                biayaJemput.innerHTML = hasil.harga_jemput;
                totalBiaya.innerHTML = hasil.total_readable;
                totalBiayaInput.value = hasil.total;
            }).catch((error) => {
                console.log(error);
            });
        };

        jumlahInput.oninput = debounce(afterInput);

        function afterInput() {
            const metode_id = Number(metodeInput.options[metodeInput.selectedIndex].value);
            const jumlah = jumlahInput.value === '' ? 0 : Number(jumlahInput.value);

            const data = JSON.stringify({
                metode_id: metode_id,
                jumlah: jumlah,
                antar: Number(antarInput.value),
                jemput: Number(jemputInput.value)
            });

            const fetchPOST = fetch(`${window.location.origin}/get/harga-pesanan`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: data,
            });

            fetchPOST.then((respon) => {
                return respon.json();
            }).then((hasil) => {
                hargaLaundry.innerHTML = hasil.harga_laundry;
                biayaAntar.innerHTML = hasil.harga_antar;
                biayaJemput.innerHTML = hasil.harga_jemput;
                totalBiaya.innerHTML = hasil.total_readable;
                totalBiayaInput.value = hasil.total;
            }).catch((error) => {
                console.log(error);
            });
        }

        function validateForm() {
            if (metodeInput.selectedIndex === 0) {
                alert('Isi data terlebih dahulu');
                return false;
            }
        }

        function debounce(func, timeout = 300){
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }
    </script>
@endsection
