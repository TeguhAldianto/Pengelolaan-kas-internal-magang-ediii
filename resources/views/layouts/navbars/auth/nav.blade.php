<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                    {{ str_replace('-', ' ', Route::currentRouteName()) }}
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">
                {{ str_replace('-', ' ', Route::currentRouteName()) }}
            </h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>

            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ route('profile.edit') }}" class="nav-link text-body font-weight-bold px-0">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm bg-gradient-info rounded-circle d-flex justify-content-center align-items-center text-white font-weight-bold shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="d-flex flex-column d-none d-sm-flex">
                                <span class="text-sm font-weight-bold">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-secondary">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
