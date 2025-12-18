<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white"
    id="sidenav-main" style="box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex align-items-center" href="{{ route('dashboard') }}">
            <div
                class="icon icon-shape icon-sm bg-gradient-dark shadow text-center border-radius-md me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-building text-white text-sm"></i>
            </div>
            <span class="font-weight-bold text-dark">Finance App</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-auto h-auto ps" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Utama</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active bg-gradient-dark text-white shadow-md' : '' }}"
                    href="{{ route('dashboard') }}" style="transition: all 0.2s ease-in-out;">

                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center
                        {{ Route::currentRouteName() == 'dashboard' ? 'bg-white text-dark' : 'bg-white text-dark' }}">
                        <i
                            class="ni ni-tv-2 text-lg {{ Route::currentRouteName() == 'dashboard' ? 'text-dark' : 'opacity-10' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->role === 'admin')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administrator</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'users.index' ? 'active bg-gradient-dark text-white shadow-md' : '' }}"
                        href="{{ route('users.index') }}" style="transition: all 0.2s ease-in-out;">

                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center
                        {{ Route::currentRouteName() == 'users.index' ? 'bg-white text-dark' : 'bg-white text-dark' }}">
                            <i
                                class="ni ni-badge text-lg {{ Route::currentRouteName() == 'users.index' ? 'text-dark' : 'opacity-10' }}"></i>
                        </div>

                        <span class="nav-link-text ms-1">Kelola Pengguna</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'manager')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'report.print' ? 'active bg-gradient-dark text-white shadow-md' : '' }}"
                        href="{{ route('report.print') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-lg text-warning opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Cetak Laporan</span>
                    </a>
                </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile.edit' ? 'active bg-gradient-dark text-white shadow-md' : '' }}"
                    href="{{ route('profile.edit') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-circle-08 text-lg text-info opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profil Saya</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidenav-footer mx-3 mt-auto pt-3">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background"
                style="background-image: url('{{ asset('assets/img/curved-images/white-curved.jpeg') }}')"></div>
            <div class="card-body text-start p-3 w-100">
                <div
                    class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="ni ni-user-run text-dark text-gradient text-lg top-0" aria-hidden="true"></i>
                </div>
                <h6 class="text-white up mb-0">Sesi Habis?</h6>
                <p class="text-xs font-weight-bold text-white">Klik tombol di bawah untuk keluar dari aplikasi.</p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="btn btn-white btn-sm w-100 mb-0">
                        Sign Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</aside>
