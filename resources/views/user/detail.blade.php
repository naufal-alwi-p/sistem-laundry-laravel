@extends('template.main')

@section('style')
    <style>
        .self-bg-row-menu {
            background-color: #54B3C7;
        }

        @media (min-width: 992px) {
            .self-w-75 {
                width: 75%;
            }

            .self-w-25 {
                width: 25%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row w-100">
        <div class="col-lg-3 self-bg-row-menu">
            <div class="mx-3">
                <h2 class="my-5">Menu</h2>
                <div class="d-flex flex-column row-gap-3 mb-5">
                    <button type="button" class="btn btn-dark">Data Pribadi</button>
                    <a href="/payment/history" class="btn btn-outline-dark">Riwayat Pembayaran</a>
                    <a href="/payment/riwayat-pesanan" class="btn btn-outline-dark">Riwayat Pesanan</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h1 class="text-center my-5">Data Pribadi</h1>

            <form id="update-form" action="/user/update-data" method="post" class="container self-w-75 mx-auto">
                @if (session('update') === true)
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil di update.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('update') === false)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data gagal di update.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" name="name" id="nama" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon:</label>
                    <input type="tel" name="telepon" id="telepon" pattern="[0-9]{11,15}" class="form-control @error('telepon') is-invalid @enderror" value="{{ $user->telepon }}">
                    @error('telepon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <p>Your Location:</p>
                    <div id="maps" class="w-100" style="height:400px"></div>
                </div>
                <div class="mb-3 row g-3 align-items-center">
                    <div class="col-2">
                        <label for="jarak" class="col-form-label">Jarak:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="jarak" id="jarak" class="form-control" readonly required placeholder="-" value="{{ $user->jarak }}">
                    </div>
                    <div class="col-1">
                        <span>Km</span>
                    </div>
                </div>
                <div class="mb-3 row g-3 align-items-center">
                    <div class="col-2">
                        <label for="latitude" class="col-form-label">Latitude:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="latitude" id="latitude" class="form-control" readonly required placeholder="-" value="{{ $user->latitude }}">
                    </div>
                </div>
                <div class="mb-3 row g-3 align-items-center">
                    <div class="col-2">
                        <label for="longitude" class="col-form-label">Longitude:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="longitude" id="longitude" class="form-control" readonly required placeholder="-" value="{{ $user->longitude }}">
                    </div>
                </div>
                <button type="button" data-bs-toggle="modal" data-bs-target="#konfirmasi_password" class="btn btn-dark mx-auto d-block self-w-25 mb-5">Update</button>
            </form>
        </div>
    </div>

    {{-- Modal Password --}}
    <div class="modal fade" id="konfirmasi_password" tabindex="-1" aria-labelledby="konfirmasi_password_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="konfirmasi_password_label">Konfirmasi Password</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="pw" class="form-label">Masukkan Password Akun:</label>
                <input type="password" class="form-control" name="password" id="pw" required form="update-form">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="update-form">Update</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: "{{ env('GOOGLE_MAPS_API_KEY') }}",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });

        let jarak;
        let latitude;
        let longitude;
        const teksJarak = document.querySelector("#jarak");
        const teksLatitude = document.querySelector("#latitude");
        const teksLongitude =document.querySelector("#longitude");

        function dataMapsValidation() {
            if (teksJarak.value === "" && teksLatitude.value === "" && teksLongitude.value === "") {
                alert("Pilih Lokasi Rumahmu di Peta");
                return false;
            }
        }

        async function initMap() {
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            const { DirectionsService, DirectionsRenderer } = await google.maps.importLibrary("routes");

            const lokasiToko = { lat: -6.599398, lng: 106.812367 };
            const userLocation = { lat: Number(teksLatitude.value), lng: Number(teksLongitude.value)};
            const directionsService = new DirectionsService();
            const directionsRenderer = new DirectionsRenderer();

            const map = new Map(document.getElementById("maps"), {
                center: lokasiToko,
                zoom: 15,
                mapId: "{{ env('GOOGLE_MAPS_ID') }}",
                mapTypeControl: false,
                streetViewControl: false
            });

            new AdvancedMarkerElement({
                map: map,
                position: lokasiToko,
                title: "Sparkling Radiant Laundry"
            });

            map.addListener("click", (e) => {
                calcRoute(e.latLng, lokasiToko, directionsService, directionsRenderer);
            });

            directionsRenderer.setMap(map);

            initRoute(userLocation, lokasiToko, directionsService, directionsRenderer);
        }

        function initRoute(start, destination, directionsService, directionsRenderer) {
            const request = {
                origin: start,
                destination: destination,
                travelMode: 'DRIVING',
                avoidTolls: true,
                provideRouteAlternatives: false,
                unitSystem:google.maps.UnitSystem.METRIC
            };

            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    console.log(result);
                }
            });
        }

        function calcRoute(start, destination, directionsService, directionsRenderer) {
            const request = {
                origin: start,
                destination: destination,
                travelMode: 'DRIVING',
                avoidTolls: true,
                provideRouteAlternatives: false,
                unitSystem:google.maps.UnitSystem.METRIC
            };

            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    jarak = Number(result.routes[0].legs[0].distance.text.split(" ")[0]);
                    latitude = start.lat();
                    longitude = start.lng();
                    teksJarak.value = jarak;
                    teksLatitude.value = latitude;
                    teksLongitude.value = longitude;
                    directionsRenderer.setDirections(result);
                } else {
                    console.log(result);
                }
            });
        }

        initMap();

    </script>
@endsection
