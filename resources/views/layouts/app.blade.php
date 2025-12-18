<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <title>Finance System - Dashboard</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
      body {
          font-family: 'Plus Jakarta Sans', sans-serif !important;
          background-color: #f8f9fa;
      }

      /* Smooth Scrollbar untuk Webkit (Chrome/Safari/Edge) */
      ::-webkit-scrollbar {
          width: 8px;
          height: 8px;
      }
      ::-webkit-scrollbar-track {
          background: #f1f1f1;
      }
      ::-webkit-scrollbar-thumb {
          background: #cbd5e0;
          border-radius: 10px;
      }
      ::-webkit-scrollbar-thumb:hover {
          background: #a0aec0;
      }

      /* Hilangkan kedipan Alpine.js */
      [x-cloak] { display: none !important; }

      /* Animasi Halus */
      .btn, .nav-link, .card {
          transition: all 0.2s ease-in-out;
      }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">

  @include('layouts.navbars.auth.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">

    @include('layouts.navbars.auth.nav')

    <div class="container-fluid py-4">
      @yield('content')

      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>document.write(new Date().getFullYear())</script>,
                Finance System Team
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>

  @stack('dashboard-scripts')

</body>
</html>
