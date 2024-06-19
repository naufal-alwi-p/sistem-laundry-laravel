@extends('template.main')

@section('style')
    <style>
        .self-color-1 {
            color: #033A8B;
        }

        .self-color-2 {
            color: #035199;
        }

        .self-banner {
            width: 100%;
            height: 648px;
        }

        .self-how-it-works {
            width: 100%;
        }

        .self-bg-banner {
            background-image: url('/assets/banner_image.png');
            background-repeat: no-repeat;
            background-position: right bottom;
            background-size: auto;
            background-clip: padding-box;
            overflow: hidden;
        }

        .w-60 {
            width: 60%;
        }

        @media (min-width: 992px) {
            .bg-lg-transparent {
                background: transparent !important;
            }

            .shadow-lg-none {
                box-shadow: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="self-banner self-bg-banner">
        <div class="ms-4 w-60 d-flex justify-content-center h-100 flex-column">
            <div class="bg-body-secondary bg-lg-transparent bg-opacity-75 p-3 p-lg-0 rounded-3 shadow shadow-lg-none">
            <h1>
                Membuat Cucianmu Menjadi Bersih dan Berkilau
            </h1>
            <p>Kami akan mencuci, mengeringkan, dan melipat cucian anda dengan harga yang terjangkau! Kami juga menyediakan Pick Up dan Drop Off! </p>
                <a href="#cara-kerja" class="btn btn-dark">Cara Kerjanya?</a>
            </div>
        </div>
    </div>

    <div class="self-how-it-works py-5 self-bg-1" id="cara-kerja">
        <h2 class="text-center pb-5"><span class="fs-3 self-color-1">Cara Kerja</span><br>Selesaikan Hanya dengan 4 Langkah</h2>
        <div class="d-flex justify-content-center column-gap-3 row-gap-3 flex-wrap">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 1</h3>
                    <p class="card-text text-center fs-5">Pick Up</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_1_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 2</h3>
                    <p class="card-text text-center fs-5">Wash & Dry</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_2_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 3</h3>
                    <p class="card-text text-center fs-5">Fold</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_3_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 4</h3>
                    <p class="card-text text-center fs-5">Delivery</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_4_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>
        </div>
    </div>

    <div class="container-sm" id="layanan">
        <h2 class="text-center my-5">Tipe Layanan</h2>

        <div class="d-flex justify-content-evenly flex-wrap row-gap-3 mb-5">
            <div class="card" style="width: 18rem; height: 23rem;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h3 class="card-title fs-4 fw-bolder text-center">Satuan</h3>
                    <p class="card-text">Memulai pembayaran secara berkala setiap minggunya dengan harga yang sudah ditetapkan</p>
                    <hr class="opacity-100">
                    <div class="row">
                        <p class="col">Kambing:</p>
                        <p class="col"><span class="fw-bold">xxx</span>/minggu</p>
                    </div>
                    <div class="row">
                        <p class="col">Sapi:</p>
                        <p class="col"><span class="fw-bold">xxx</span>/minggu</p>
                    </div>
                    <div class="row mb-3">
                        <div class="col fw-bold">Jatuh Tempo:</div>
                        <div class="col text-end">xxx</div>
                    </div>
                    <a href="/user/daftar-qurban" class="btn btn-dark">Pilih</a>
                </div>
            </div>

            <div class="card" style="width: 18rem; height: 23rem;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h3 class="card-title fs-4 fw-bolder text-center">Kiloan</h3>
                    <p class="card-text">Memulai pembayaran secara berkala setiap bulannya dengan harga yang sudah ditetapkan</p>
                    <hr class="opacity-100">
                    <div class="row">
                        <p class="col">Kambing:</p>
                        <p class="col"><span class="fw-bold">xxx</span>/bulan</p>
                    </div>
                    <div class="row">
                        <p class="col">Sapi:</p>
                        <p class="col"><span class="fw-bold">xxx</span>/bulan</p>
                    </div>
                    <div class="row mb-3">
                        <div class="col fw-bold">Jatuh Tempo:</div>
                        <div class="col text-end">xxx</div>
                    </div>
                    <a href="/user/daftar-qurban" class="btn btn-dark">Pilih</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-sm">
        <h2 class="text-center my-5">Ulasan Toko</h2>
        <p class="text-center fs-5">
            “Situs web Sparkling Radiant Laundry keren banget, bikin hidup aku lebih gampang! Anterin-jemput pakaian itu kayak jadi pahlawan aku yang ngelawan antrean panjang. Hasilnya? Pakaian bersih dan wangi, tanpa gangguan! Cuma bisa bilang, Sprakling Radiant Laundry emang pilihan bintang lima buat yang sibuk kayak aku gitu!”
        </p>
        <img class="d-block rounded-circle mx-auto mb-2" src="/assets/pelanggan.png" alt="Ulasan Pelanggan">
        <p class="text-center fs-2">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
        </p>
        <p class="text-center fs-5">Amamiya Sora</p>
    </div>

    <div class="container-sm mb-5">
        <h2 class="text-center my-5">Lokasi</h2>
        <div id="maps" class="w-full" style="height: 400px"></div>
    </div>
@endsection

@section('script')
    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: "AIzaSyA9ZnGCuLjAudiEb3aoXRi9dSahEfwB7ZQ",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });

        async function initMap() {
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            const lokasiToko = { lat: -6.599398, lng: 106.812367 }

            const map = new Map(document.getElementById("maps"), {
                center: lokasiToko,
                zoom: 15,
                mapId: "5d2d70410f064101",
                mapTypeControl: false,
                streetViewControl: false
            });

            new AdvancedMarkerElement({
                map: map,
                position: lokasiToko,
                title: "Sparkling Radiant Laundry"
            });
        }

        initMap();
    </script>
@endsection
