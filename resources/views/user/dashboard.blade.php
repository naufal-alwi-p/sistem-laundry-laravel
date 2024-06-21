@extends('template.main')

@section('style')
    <style>
        .self-full-height {
            min-height: calc(100vh - 56px);
        }

        .self-opacity-100 {
            opacity: 1;
        }

        .self-hover-btn:hover {
            background-color: rgb(var(--bs-secondary-bg-rgb))
        }

        @media (max-width: 767px) {
            .self-w-600 {
                width: 1000px;
            }
        }
    </style>
@endsection

@section('content')
    <h1 class="text-center my-4">Dashboard</h1>
    <div class="container mb-3 self-full-height">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Status Pemesanan</h2>
            <a href="/user/buat-pesanan" class="my-1 btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</i></a>
        </div>

        <hr class="border-top border-2 border-black self-opacity-100">

        <div class="card">
            <div class="card-body overflow-x-auto">
                <div class="row self-w-600">
                    <div class="col-4 fw-bold text-center">ID Pesanan</div>
                    <div class="col-3 fw-bold text-center">Status</div>
                    <div class="col-2 fw-bold text-center">Jumlah</div>
                    <div class="col-3 fw-bold text-center">Jenis Cucian</div>
                </div>
                <hr class="self-w-600">
                @forelse ($pesanan_aktif as $pesanan)
                    @if ($loop->last)
                        <a class="row self-w-600 d-flex border border-3 border-dark rounded-pill py-3 text-decoration-none text-black self-hover-btn" href="/user/detail-pesanan/{{ $pesanan->id }}">
                            <div class="col-4 text-center">{{ $pesanan->id }}</div>
                            <div class="col-3 text-center">{{ $pesanan->status }}</div>
                            <div class="col-2 text-center">{{ $pesanan->jumlah }}</div>
                            <div class="col-3 text-center">{{ $pesanan->jenisCucian->nama }}</div>
                        </a>
                    @else
                        <a class="row self-w-600 d-flex border border-3 border-dark rounded-pill mb-3 py-3 text-decoration-none text-black self-hover-btn" href="/user/detail-pesanan/{{ $pesanan->id }}">
                            <div class="col-4 text-center">{{ $pesanan->id }}</div>
                            <div class="col-3 text-center">{{ $pesanan->status }}</div>
                            <div class="col-2 text-center">{{ $pesanan->jumlah }}</div>
                            <div class="col-3 text-center">{{ $pesanan->jenisCucian->nama }}</div>
                        </a>
                    @endif
                @empty
                    <p class="text-secondary-emphasis text-center">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="container mb-5 self-full-height">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Riwayat Pemesanan</h2>
            <a href="/user/riwayat-pesanan" class="my-1 btn btn-primary">Selengkapnya <i class="bi bi-caret-right-fill"></i></a>
        </div>

        <hr class="border-top border-2 border-black self-opacity-100">

        <div class="card">
            <div class="card-body overflow-x-auto">
                <div class="row self-w-600">
                    <div class="col-4 fw-bold text-center">ID Pesanan</div>
                    <div class="col-3 fw-bold text-center">Status</div>
                    <div class="col-2 fw-bold text-center">Jumlah</div>
                    <div class="col-3 fw-bold text-center">Jenis Cucian</div>
                </div>
                <hr class="self-w-600">
                @forelse ($riwayat_pesanan as $pesanan)
                    @if ($loop->last)
                        <a class="row self-w-600 d-flex border border-3 border-dark rounded-pill py-3 text-decoration-none text-black self-hover-btn" href="/user/detail-pesanan/{{ $pesanan->id }}">
                            <div class="col-4 text-center">{{ $pesanan->id }}</div>
                            <div class="col-3 text-center">{{ $pesanan->status }}</div>
                            <div class="col-2 text-center">{{ $pesanan->jumlah }}</div>
                            <div class="col-3 text-center">{{ $pesanan->jenisCucian->nama }}</div>
                        </a>
                    @else
                        <a class="row self-w-600 d-flex border border-3 border-dark rounded-pill mb-3 py-3 text-decoration-none text-black self-hover-btn" href="/user/detail-pesanan/{{ $pesanan->id }}">
                            <div class="col-4 text-center">{{ $pesanan->id }}</div>
                            <div class="col-3 text-center">{{ $pesanan->status }}</div>
                            <div class="col-2 text-center">{{ $pesanan->jumlah }}</div>
                            <div class="col-3 text-center">{{ $pesanan->jenisCucian->nama }}</div>
                        </a>
                    @endif
                @empty
                    <p class="text-secondary-emphasis text-center">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection