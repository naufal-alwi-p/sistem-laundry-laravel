@extends('template.main_no_navbar_footer')

@section('style')
    <style>
        body {
            background-image: url("/assets/Login.png");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            position: relative;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: white;
            padding: 20px 80px;
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
        <img src="/assets/logo.png" alt="Logo" class="mx-auto d-block">
        <h2 class="text-center">Selamat Datang di Sparkling Radiant Laundry</h2>
        <p class="text-center">Silahkan Login Untuk Dapat Memesan Layanan Kami</p>
        <form method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control border border-dark @error('email') is-invalid @enderror" id="exampleFormControlInput1">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control border border-dark" id="exampleFormControlInput1">
            </div>
            <button type="submit" class="btn btn-primary d-block mb-3 mx-auto">Masuk</button>
            <a class="text-center d-block" href="/user/register">Belum punya akun? Daftar disini</a>
        </form>
    </div>
@endsection
