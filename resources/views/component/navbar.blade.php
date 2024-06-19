<nav @class(['navbar', 'sticky-top', 'navbar-expand-lg', 'shadow-sm', 'bg-white' => Illuminate\Support\Facades\Route::current()->uri() === '/', 'self-bg-nav' => Illuminate\Support\Facades\Route::current()->uri() !== '/'])>
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/"><img src="/assets/logo.svg" alt="Logo Sparkling Radiant Laundry"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul @class(['navbar-nav', 'mb-2', 'mb-lg-0', 'me-lg-5' => Illuminate\Support\Facades\Auth::check() || Illuminate\Support\Facades\Auth::guard('admin')->check(), 'pe-lg-4' => Illuminate\Support\Facades\Auth::check()])>
                <li class="nav-item">
                    <a @class(['nav-link', 'fw-medium', 'active' => Illuminate\Support\Facades\Route::current()->uri() === '/']) href="/">Home</a>
                </li>
                @auth('web')
                    <li class="nav-item">
                        <a @class(['nav-link', 'fw-medium', 'active' => Illuminate\Support\Facades\Route::current()->uri() === 'user/dashboard']) href="/user/dashboard">Dashboard</a>
                    </li>
                @endauth

                @auth('admin')
                    <li class="nav-item">
                        <a @class(['nav-link', 'fw-medium', 'active' => Illuminate\Support\Facades\Route::current()->uri() === 'admin/dashboard']) href="/admin/dashboard">Dashboard</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="/#cara-kerja">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="/#layanan">Layanan</a>
                </li>
                @auth('web')
                <li class="nav-item fw-medium dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Halo, {{ explode(" ", Illuminate\Support\Facades\Auth::user()->name)[0] }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/user/detail">Detail Akun</a></li>
                        <li><form action="/user/logout" method="post">@csrf<button class="dropdown-item text-danger">Logout</button></form></li>
                    </ul>
                </li>
                @endauth

                @auth('admin')
                <li class="nav-item fw-medium dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin {{ explode(" ", Illuminate\Support\Facades\Auth::guard('admin')->user()->name)[0] }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/detail">Detail Akun</a></li>
                        <li><form action="/admin/logout" method="post">@csrf<button class="dropdown-item text-danger">Logout</button></form></li>
                    </ul>
                </li>
                @endauth

                @if (!(Illuminate\Support\Facades\Auth::guard('admin')->check() || Illuminate\Support\Facades\Auth::guard('web')->check()))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/user/login">Sebagai User</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/admin/login">Sebagai Admin</a></li>
                        </ul>
                    </li>
                    <a class="btn btn-primary mx-lg-1" href="/user/register">User Register</a>
                @endif
            </ul>
        </div>
    </div>
</nav>