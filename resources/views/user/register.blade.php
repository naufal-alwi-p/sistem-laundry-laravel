@extends('template.main_no_navbar_footer')

@section('style')
    <style>
        body {
            background-image: url("/assets/Login.png");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            /* position: relative; */
            /* height: 100vh; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: white;
            padding: 20px 80px;
            margin-top: 96px;
            margin-bottom: 96px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 869px;
            /* text-align: center; */
        }

        .login-card img {
            max-width: 150px;
        }

        /* .login-card .form-control {
                margin-bottom: 10px;
            }
            .login-card .btn-primary {
                width: 100%;
            }
            .login-card a {
                display: block;
                margin-top: 10px;
            } */
    </style>
@endsection

@section('content')
    <div class="login-card">
        <a href="/" class="mx-auto d-block"><img src="/assets/logo.png" alt="Logo" class="mx-auto d-block"></a>
        <h2 class="text-center">Selamat Datang di Sparkling Radiant Laundry</h2>
        <p class="text-center">Silahkan Registrasi Untuk Dapat Memesan Layanan Kami</p>
        <form method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" name="name" id="nama" class="form-control" placeholder="Your name..." required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="email@example.com" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon:</label>
                <input type="tel" name="telepon" id="telepon" class="form-control" pattern="[0-9]{11,12}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
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
                    <input type="number" name="jarak" id="jarak" class="form-control" readonly required placeholder="-">
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
                    <input type="number" name="latitude" id="latitude" class="form-control" readonly required placeholder="-">
                </div>
            </div>
            <div class="mb-3 row g-3 align-items-center">
                <div class="col-2">
                    <label for="longitude" class="col-form-label">Longitude:</label>
                </div>
                <div class="col-auto">
                    <input type="number" name="longitude" id="longitude" class="form-control" readonly required placeholder="-">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3 d-block mx-auto">Daftar</button>
            <a class="text-center d-block" href="/user/login">Sudah punya akun? login</a>
        </form>
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

            const lokasiToko = { lat: -6.599398, lng: 106.812367 }
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
